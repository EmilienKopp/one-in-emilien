<?php

namespace App\Services\Blog\Publishers;

use App\Exceptions\MissingApiKeyException;
use App\Services\Blog\BlogPost;
use App\Services\Blog\Contracts\BlogPublisher;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;

class HashnodePublisher implements BlogPublisher
{
    private const ENDPOINT = 'https://gql.hashnode.com/';

    public function name(): string
    {
        return 'Hashnode';
    }

    public function locale(): string
    {
        return 'en';
    }

    public function publish(BlogPost $post): string
    {
        if (! config('services.hashnode.api_key')) {
            throw new MissingApiKeyException('Hashnode');
        }

        $tags = array_map(
            fn (string $tag) => ['name' => $tag, 'slug' => str($tag)->slug()->toString()],
            $post->tags
        );

        $input = array_filter([
            'title' => $post->title,
            'publicationId' => config('services.hashnode.publication_id'),
            'contentMarkdown' => $post->body,
            'tags' => $tags ?: null,
            'coverImageOptions' => $post->coverImage
                ? ['coverImageURL' => $post->coverImage]
                : null,
        ]);

        $response = Http::withToken(config('services.hashnode.api_key'))
            ->post(self::ENDPOINT, [
                'query' => '
                    mutation PublishPost($input: PublishPostInput!) {
                        publishPost(input: $input) {
                            post { id url title }
                        }
                    }
                ',
                'variables' => ['input' => $input],
            ])
            ->throw();

        $data = $response->json('data.publishPost.post');

        throw_unless($data, RequestException::class, 'Hashnode returned no post data');

        return $data['url'];
    }
}
