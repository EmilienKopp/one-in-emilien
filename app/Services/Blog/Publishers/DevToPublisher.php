<?php

namespace App\Services\Blog\Publishers;

use App\Exceptions\MissingApiKeyException;
use App\Services\Blog\BlogPost;
use App\Services\Blog\Contracts\BlogPublisher;
use Illuminate\Support\Facades\Http;

class DevToPublisher implements BlogPublisher
{
    private const ENDPOINT = 'https://dev.to/api/articles';

    public function name(): string
    {
        return 'dev.to';
    }

    public function locale(): string
    {
        return 'en';
    }

    public function publish(BlogPost $post): string
    {
        if (! config('services.devto.api_key')) {
            throw new MissingApiKeyException('dev.to');
        }

        $payload = array_filter([
            'title' => $post->title,
            'body_markdown' => $post->body,
            'published' => true,
            'tags' => $post->tags ?: null,
            'canonical_url' => $post->canonicalUrl,
            'main_image' => $post->coverImage,
        ]);

        $response = Http::withHeaders(['api-key' => config('services.devto.api_key')])
            ->post(self::ENDPOINT, ['article' => $payload])
            ->throw();

        return $response->json('url');
    }
}
