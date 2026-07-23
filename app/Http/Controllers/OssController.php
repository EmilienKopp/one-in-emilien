<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Inertia\Inertia;
use Inertia\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class OssController extends Controller
{
    /**
     * Registry of open source packages keyed by slug.
     *
     * Add a new package by appending an entry below and dropping its images in
     * `public/images/oss/{slug}/`. Sections render as an alternating
     * image/text grid in the order listed.
     *
     * @return array<string, array{
     *     name: string,
     *     tagline: string,
     *     description: string,
     *     repository?: string,
     *     packagist?: string,
     *     sections: list<array{image: string, alt?: string, title: string, body: string}>
     * }>
     */
    protected function packages(): array
    {
        $json = file_get_contents(resource_path('data/oss.json'));

        return json_decode($json, true, 512, JSON_THROW_ON_ERROR);
    }

    public function index(): Response
    {
        $packages = collect($this->packages())
            ->map(fn (array $package, string $slug): array => [
                'slug' => $slug,
                'name' => $package['name'],
                'tagline' => $package['tagline'],
                'downloads' => $this->downloads($package['packagist'] ?? null),
            ])
            ->sortByDesc('downloads')
            ->values()
            ->all();

        return Inertia::render('Oss/Index', [
            'packages' => $packages,
        ]);
    }

    public function show(string $package): Response
    {
        $data = $this->packages()[$package] ?? throw new NotFoundHttpException("Unknown package [{$package}].");

        return Inertia::render('Oss/Show', [
            'slug' => $package,
            'package' => [
                ...$data,
                'downloads' => $this->downloads($data['packagist'] ?? null),
            ],
        ]);
    }

    /**
     * Fetch the total Packagist download count for a package, cached daily.
     *
     * Returns null when the package has no Packagist URL or the API is
     * unreachable, so the frontend can simply hide the badge.
     */
    protected function downloads(?string $packagistUrl): ?int
    {
        if ($packagistUrl === null) {
            return null;
        }

        $name = trim(parse_url($packagistUrl, PHP_URL_PATH) ?? '', '/');
        $name = preg_replace('#^packages/#', '', $name);

        if ($name === '' || $name === null) {
            return null;
        }

        return Cache::remember("oss.downloads.{$name}", now()->addDay(), function () use ($name): ?int {
            $response = Http::timeout(5)->get("https://packagist.org/packages/{$name}.json");

            if ($response->failed()) {
                return null;
            }

            return $response->json('package.downloads.total');
        });
    }
}
