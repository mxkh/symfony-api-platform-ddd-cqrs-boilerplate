<?php

declare(strict_types=1);

namespace Sweetspot\Domain\Shared\Exception;

class NonUniqueUuidException extends \InvalidArgumentException
{
    public function __construct()
    {
        parent::__construct('UUID already registered.');
    }
}
