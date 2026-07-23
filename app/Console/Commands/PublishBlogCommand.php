<?php

namespace App\Console\Commands;

use App\Services\Blog\BlogPost;
use App\Services\Blog\PublisherRegistry;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Throwable;

class PublishBlogCommand extends Command
{
    protected $signature = 'blog:publish
                            {date? : Date folder to publish (YYYY-MM-DD), defaults to today}
                            {--dry-run : Parse and display posts without publishing}';

    protected $description = 'Publish blog posts from drafts/blog/{date}/ to all configured platforms';

    public function __construct(private readonly PublisherRegistry $registry)
    {
        parent::__construct();
    }

    public function handle(): int
    {
        $date = $this->argument('date') ?? now('UTC')->format('Y-m-d');
        $dir = base_path("drafts/blog/{$date}");

        if (! File::isDirectory($dir)) {
            $this->warn("No blog folder found for {$date}.");

            return self::SUCCESS;
        }

        $files = File::glob("{$dir}/*.md");

        if (empty($files)) {
            $this->warn("No markdown files in {$dir}.");

            return self::SUCCESS;
        }

        $manifest = $this->loadManifest($dir);

        foreach ($files as $path) {
            $filename = basename($path);

            if ($this->alreadyPublished($manifest, $filename)) {
                $this->line("  Skipping {$filename} (already published)");

                continue;
            }

            $post = BlogPost::fromMarkdown($filename, File::get($path));
            $publishers = $this->registry->for($post->locale);

            if (empty($publishers)) {
                $this->warn("  No publishers registered for locale '{$post->locale}' ({$filename})");

                continue;
            }

            $this->info("Publishing [{$post->locale}]: {$post->title}");

            if ($this->option('dry-run')) {
                foreach ($publishers as $publisher) {
                    $this->line("  [dry-run] → {$publisher->name()}");
                }
                $this->line('  Tags: '.implode(', ', $post->tags ?: ['(none)']));

                continue;
            }

            $entry = ['published_at' => now('UTC')->toIso8601String()];
            $canonicalUrl = null;

            foreach ($publishers as $publisher) {
                try {
                    $url = $publisher->publish($post->withCanonicalUrl($canonicalUrl ?? ''));
                    $entry[$publisher->name().'_url'] = $url;
                    $this->line("  {$publisher->name()}: {$url}");

                    $canonicalUrl ??= $url;
                } catch (Throwable $e) {
                    $this->error("  {$publisher->name()} failed: {$e->getMessage()}");
                }
            }

            $manifest[$filename] = $entry;
            $this->saveManifest($dir, $manifest);
        }

        return self::SUCCESS;
    }

    private function alreadyPublished(array $manifest, string $filename): bool
    {
        return isset($manifest[$filename]['published_at'])
            && \count($manifest[$filename]) > 1; // has at least one platform URL
    }

    private function loadManifest(string $dir): array
    {
        $path = "{$dir}/published.json";

        return File::exists($path) ? json_decode(File::get($path), true) : [];
    }

    private function saveManifest(string $dir, array $manifest): void
    {
        File::put("{$dir}/published.json", json_encode($manifest, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
    }
}
