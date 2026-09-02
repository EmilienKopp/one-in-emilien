<?php

namespace App\Support;

use Closure;
use Illuminate\Support\Collection;

class Parsing
{
    public static function parseMeta(string $filePath): array
    {
        $meta = [];
        if (file_exists($filePath)) {
            $content = file_get_contents($filePath);
            if (preg_match('/<title>(.*?)<\/title>/', $content, $matches)) {
                $meta['title'] = $matches[1];
            }
            if (preg_match('/<meta name="description" content="(.*?)">/', $content, $matches)) {
                $meta['description'] = $matches[1];
            }
        }

        return $meta;
    }

    public static function collectDirectory(string $directoryPath): Collection
    {
        return collect(scandir($directoryPath))
            ->filter(fn (string $file): bool => ! str_starts_with($file, '.'))
            ->map(fn (string $file): string => pathinfo($file, PATHINFO_FILENAME))
            ->values();
    }

    public static function collectEmbeddedFiles(string $embeddedPath): Collection
    {
        return collect(scandir($embeddedPath))
            ->filter(fn (string $file): bool => ! str_starts_with($file, '.'))
            ->values();
    }

    public static function mapSvelteWithMeta(Collection $directories, string $path): Collection
    {
        return collect($directories)
            ->map(function (string $directory) use ($path): TalkMeta {
                $meta = json_decode(
                    file_get_contents("{$path}/{$directory}/meta.json"),
                    true,
                    512,
                    JSON_THROW_ON_ERROR
                );

                return new TalkMeta(
                    slug: $directory,
                    title: $meta['title'] ?? $directory,
                    description: $meta['description'] ?? '',
                    time: filectime("{$path}/{$directory}"),
                );
            })
            ->values();
    }

    public static function mapEmbeddedWithMeta(
        Collection $embeddedFiles,
        string $embeddedPath,
        ?Closure $parser = null
    ): Collection {
        $parser ??= self::parseMeta(...);

        return collect($embeddedFiles)
            ->map(function (string $file) use ($embeddedPath, $parser): TalkMeta {
                $meta = $parser("{$embeddedPath}/{$file}");
                $time = filectime("{$embeddedPath}/{$file}");
                $file = str(pathinfo($file, PATHINFO_FILENAME))->replace('.blade', '');

                return new TalkMeta(
                    slug: $file,
                    title: $meta['title'] ?? $file,
                    description: $meta['description'] ?? '',
                    time: $time,
                );
            })
            ->values();
    }
}
