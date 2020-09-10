<?php

namespace Acme\Domain\User\Repository;

use Acme\Domain\User\User;
use Ramsey\Uuid\UuidInterface;

interface UserRepositoryInterface
{
    public function get(UuidInterface $uuid): User;

    public function store(User $user): void;
}
