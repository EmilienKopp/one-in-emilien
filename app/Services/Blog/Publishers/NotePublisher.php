<?php

namespace App\Services\Blog\Publishers;

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
        // note.com does not have a public API yet — manual publish required.
        throw new \RuntimeException('note.com publishing is not yet supported.');
    }
}
