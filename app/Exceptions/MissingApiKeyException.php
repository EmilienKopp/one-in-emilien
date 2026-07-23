<?php

namespace App\Exceptions;

class MissingApiKeyException extends UnpublishableException
{
    public function __construct(string $publisher)
    {
        parent::__construct($publisher, 'API key is not configured');
    }
}
