<?php

declare(strict_types=1);

namespace Acme\Domain\Shared\ValueObject\Specification;

final class BusinessRuleValidationMessage
{
    public string $message;

    public int $code;

    public function __construct(string $message, int $code)
    {
        $this->message = $message;
        $this->code = $code;
    }
}
