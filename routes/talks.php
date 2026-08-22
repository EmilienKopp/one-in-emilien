<?php

use Inertia\Inertia;

$path = resource_path('js/pages/talks/deck');

$directories = collect(scandir($path))
    ->filter(fn (string $file): bool => ! str_starts_with($file, '.'))
    ->map(fn (string $file): string => pathinfo($file, PATHINFO_FILENAME))
    ->sortByDesc(fn (string $directory): int => filectime("{$path}/{$directory}"))
    ->values()
    ->all();

Route::get('/', function () use ($path, $directories) {
    return Inertia::render('talks/Index', [
        'talks' => collect($directories)
            ->map(function (string $directory) use ($path): array {
                $meta = json_decode(
                    file_get_contents("{$path}/{$directory}/meta.json"),
                    true,
                    512,
                    JSON_THROW_ON_ERROR
                );

                return [
                    'slug' => $directory,
                    'title' => $meta['title'] ?? $directory,
                    'description' => $meta['description'] ?? '',
                ];
            })
            ->sortBy('meta.title')
            ->values()
            ->all(),
    ]);
})->name('talks.index');

foreach ($directories as $directory) {
    Route::get("/{$directory}", function () use ($directory) {
        return Inertia::render("talks/deck/{$directory}/Index", [
            'surveyUrl' => config('services.talks.survey_url'),
        ])->rootView('talks');
    })->name("talks.{$directory}");
}
