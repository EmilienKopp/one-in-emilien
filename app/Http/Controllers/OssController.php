<?php

namespace App\Http\Controllers;

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
        $json = file_get_contents(storage_path('app/private/oss.json'));

        return json_decode($json, true, 512, JSON_THROW_ON_ERROR);
    }

    public function index(): Response
    {
        $packages = collect($this->packages())
            ->map(fn (array $package, string $slug): array => [
                'slug' => $slug,
                'name' => $package['name'],
                'tagline' => $package['tagline'],
            ])
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
            'package' => $data,
        ]);
    }
}
