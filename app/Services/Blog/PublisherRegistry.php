<?php

namespace App\Services\Blog;

use App\Services\Blog\Contracts\BlogPublisher;
use App\Services\Blog\Publishers\DevToPublisher;
use App\Services\Blog\Publishers\HashnodePublisher;
use App\Services\Blog\Publishers\NotePublisher;
use Illuminate\Support\Collection;

class PublisherRegistry
{
    /** @var array<string, BlogPublisher[]> locale → ordered publishers (first sets canonical URL) */
    private array $publishers;

    public function __construct(
        HashnodePublisher $hashnode,
        DevToPublisher $devTo,
        NotePublisher $note,
    ) {
        $this->publishers = [
            'en' => [$hashnode, $devTo],
            'jp' => [$note],
        ];
    }

    /** @return BlogPublisher[] */
    public function for(string $locale): array
    {
        return $this->publishers[$locale] ?? [];
    }

    /** @return Collection<string, BlogPublisher[]> */
    public function all(): Collection
    {
        return collect($this->publishers);
    }
}
