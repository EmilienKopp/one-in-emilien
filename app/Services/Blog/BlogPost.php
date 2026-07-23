<?php

namespace App\Services\Blog;

final class BlogPost
{
    public function __construct(
        public readonly string $filename,
        public readonly string $locale,
        public readonly string $title,
        public readonly string $body,
        public readonly array $tags = [],
        public readonly ?string $coverImage = null,
        public readonly ?string $canonicalUrl = null,
    ) {}

    public function withCanonicalUrl(string $url): self
    {
        return new self(
            filename: $this->filename,
            locale: $this->locale,
            title: $this->title,
            body: $this->body,
            tags: $this->tags,
            coverImage: $this->coverImage,
            canonicalUrl: $url,
        );
    }

    public static function fromMarkdown(string $filename, string $content): self
    {
        $locale = self::detectLocale($filename);
        $tags = [];
        $coverImage = null;

        if (str_starts_with($content, '---')) {
            $end = strpos($content, '---', 3);
            if ($end !== false) {
                $frontmatter = substr($content, 3, $end - 3);
                $content = ltrim(substr($content, $end + 3));

                if (preg_match('/^tags:\s*\[([^\]]+)\]/m', $frontmatter, $m)) {
                    $tags = array_map('trim', explode(',', $m[1]));
                } elseif (preg_match('/^tags:\s*(.+)$/m', $frontmatter, $m)) {
                    $tags = array_map('trim', explode(',', $m[1]));
                }

                if (preg_match('/^cover_image:\s*(.+)$/m', $frontmatter, $m)) {
                    $coverImage = trim($m[1]);
                }
            }
        }

        $title = '';
        $bodyLines = [];
        $titleFound = false;

        foreach (explode("\n", $content) as $line) {
            if (! $titleFound && str_starts_with($line, '# ')) {
                $title = ltrim($line, '# ');
                $titleFound = true;
            } else {
                $bodyLines[] = $line;
            }
        }

        return new self(
            filename: $filename,
            locale: $locale,
            title: trim($title),
            body: ltrim(implode("\n", $bodyLines)),
            tags: array_values(array_filter($tags)),
            coverImage: $coverImage,
        );
    }

    private static function detectLocale(string $filename): string
    {
        $base = pathinfo($filename, PATHINFO_FILENAME);

        return match (true) {
            str_ends_with($base, '-jp') => 'jp',
            str_ends_with($base, '-en') => 'en',
            default => 'en',
        };
    }
}
