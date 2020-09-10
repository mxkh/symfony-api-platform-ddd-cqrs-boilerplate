<?php

declare(strict_types=1);

namespace Acme\Domain\Shared\Query\Exception;

final class NotFoundException extends \Exception
{
    public function __construct()
    {
        parent::__construct('Resource not found');
    }
}
