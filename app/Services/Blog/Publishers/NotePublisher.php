<?php

namespace App\Services\Blog\Publishers;

use App\Exceptions\UnpublishableException;
use App\Services\Blog\BlogPost;
use App\Services\Blog\Contracts\BlogPublisher;

class NotePublisher implements BlogPublisher
{
    public function name(): string
    {
        return 'note.com';
    }

    public function locale(): string
    {
        return 'jp';
    }

    public function publish(BlogPost $post): string
    {
        throw new UnpublishableException('note.com', 'no public API available — manual publish required');
    }
}
