<?php

use App\Support\Parsing;
use Inertia\Inertia;

$path = resource_path('js/pages/talks/deck');
$embeddedPath = resource_path('views/embedded');

$directories = Parsing::collectDirectory($path);
$embeddedFiles = Parsing::collectEmbeddedFiles($embeddedPath);
$svelte = Parsing::mapSvelteWithMeta($directories, $path);
$blade = Parsing::mapEmbeddedWithMeta($embeddedFiles, $embeddedPath);

Route::get('/', function () use ($svelte, $blade) {

    $orderedTalks = $svelte->merge($blade)
        ->sortByDesc('time')
        ->values();

    return Inertia::render('talks/Index', [
        'talks' => $orderedTalks,
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
