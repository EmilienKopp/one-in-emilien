<?php

use App\Support\Parsing;
use Inertia\Inertia;

$path = resource_path('js/pages/talks/deck');
$embeddedPath = resource_path('views/embedded');
$talksConfig = json_decode(file_get_contents(config_path('talks.json')), true);

$directories = Parsing::collectDirectory($path);
$embeddedFiles = Parsing::collectEmbeddedFiles($embeddedPath);
$svelte = Parsing::mapSvelteWithMeta($directories, $path);
$blade = Parsing::mapEmbeddedWithMeta($embeddedFiles, $embeddedPath);

Route::get('/', function () use ($svelte, $blade, $talksConfig) {

    $orderedTalks = $svelte->merge($blade)
        ->sortByDesc('time')
        ->values();

    $redirects = collect($talksConfig['redirects'])->map(fn($redirect) => [
        'slug' => $redirect['path'],
        'description' => $redirect['label'],
        'isRedirect' => true,
        'url' => $redirect['url'],
    ]);

    $allTalks = $orderedTalks->concat($redirects);

    return Inertia::render('talks/Index', [
        'talks' => $allTalks,
    ]);
})->name('talks.index');

Route::get('/embedded/{page}', function (string $page) {})->name('embedded.page');

foreach ($directories as $directory) {
    Route::get("/{$directory}", function () use ($directory) {
        return Inertia::render("talks/deck/{$directory}/Index", [
            'surveyUrl' => config('services.talks.survey_url'),
        ])->rootView('talks');
    })->name("talks.{$directory}");
}

foreach ($embeddedFiles as $file) {
    $name = str(pathinfo($file, PATHINFO_FILENAME))->replace('.blade', '');
    Route::get("/{$name}", function () use ($name) {
        return view("embedded.{$name}");
    })->name("talks.{$name}");
}

foreach ($talksConfig['redirects'] as $redirect) {
    Route::get("/{$redirect['path']}", fn() => redirect($redirect['url']));
}
