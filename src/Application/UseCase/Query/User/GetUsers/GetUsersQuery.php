<?php

declare(strict_types=1);

namespace Acme\Application\UseCase\Query\User\GetUsers;

use Acme\Application\UseCase\Query\CollectionQuery;
use Acme\Domain\User\User;

class GetUsersQuery extends CollectionQuery
{
    public static function createWithContext(array $context): CollectionQuery
    {
        return new self($context);
    }

    public static function resourceClass(): string
    {
        return User::class;
    }
}
