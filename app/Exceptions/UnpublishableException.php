<?php

namespace App\Exceptions;

class UnpublishableException extends \RuntimeException
{
    public function __construct(string $publisher, string $reason = '', ?\Throwable $previous = null)
    {
        $message = $reason
            ? "Cannot publish to {$publisher}: {$reason}"
            : "Cannot publish to {$publisher}";

        parent::__construct($message, 0, $previous);
    }
}
