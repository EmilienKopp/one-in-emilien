<?php

namespace App\Services\Blog\Contracts;

use App\Services\Blog\BlogPost;

interface BlogPublisher
{
    public function name(): string;

    public function locale(): string;

    /** Publish the post and return its public URL. */
    public function publish(BlogPost $post): string;
}
