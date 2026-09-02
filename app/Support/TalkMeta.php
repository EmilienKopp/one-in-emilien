<?php

namespace App\Support;

class TalkMeta
{
    public function __construct(
        public string $slug,
        public string $title,
        public string $description,
        public int $time
    ) {}
}
