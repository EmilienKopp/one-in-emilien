<?php

use App\Exceptions\MissingApiKeyException;
use App\Exceptions\UnpublishableException;
use App\Services\Blog\BlogPost;
use App\Services\Blog\Publishers\DevToPublisher;
use App\Services\Blog\Publishers\HashnodePublisher;
use App\Services\Blog\Publishers\NotePublisher;
use Illuminate\Support\Facades\Http;

function makePost(): BlogPost
{
    return new BlogPost(
        filename: 'test-post-en.md',
        locale: 'en',
        title: 'Test Post',
        body: '## Hello world',
        tags: ['php', 'laravel'],
    );
}

describe('HashnodePublisher', function () {
    it('throws MissingApiKeyException when api key is not configured', function () {
        config(['services.hashnode.api_key' => null]);

        expect(fn () => (new HashnodePublisher)->publish(makePost()))
            ->toThrow(MissingApiKeyException::class, 'API key is not configured');
    });

    it('MissingApiKeyException is an UnpublishableException', function () {
        config(['services.hashnode.api_key' => null]);

        expect(fn () => (new HashnodePublisher)->publish(makePost()))
            ->toThrow(UnpublishableException::class);
    });

    it('publishes and returns url on success', function () {
        config([
            'services.hashnode.api_key' => 'test-key',
            'services.hashnode.publication_id' => 'pub-123',
        ]);

        Http::fake([
            'gql.hashnode.com/*' => Http::response([
                'data' => [
                    'publishPost' => [
                        'post' => ['id' => '1', 'url' => 'https://hashnode.com/post/1', 'title' => 'Test Post'],
                    ],
                ],
            ]),
        ]);

        $url = (new HashnodePublisher)->publish(makePost());

        expect($url)->toBe('https://hashnode.com/post/1');
    });
});

describe('DevToPublisher', function () {
    it('throws MissingApiKeyException when api key is not configured', function () {
        config(['services.devto.api_key' => null]);

        expect(fn () => (new DevToPublisher)->publish(makePost()))
            ->toThrow(MissingApiKeyException::class, 'API key is not configured');
    });

    it('publishes and returns url on success', function () {
        config(['services.devto.api_key' => 'test-key']);

        Http::fake([
            'dev.to/*' => Http::response(['url' => 'https://dev.to/user/test-post']),
        ]);

        $url = (new DevToPublisher)->publish(makePost());

        expect($url)->toBe('https://dev.to/user/test-post');
    });
});

describe('NotePublisher', function () {
    it('throws UnpublishableException because there is no public API', function () {
        expect(fn () => (new NotePublisher)->publish(makePost()))
            ->toThrow(UnpublishableException::class, 'no public API available');
    });
});

describe('UnpublishableException', function () {
    it('formats message with publisher and reason', function () {
        $e = new UnpublishableException('Hashnode', 'something went wrong');

        expect($e->getMessage())->toBe('Cannot publish to Hashnode: something went wrong');
    });

    it('formats message with publisher name only', function () {
        $e = new UnpublishableException('Hashnode');

        expect($e->getMessage())->toBe('Cannot publish to Hashnode');
    });
});
