<?php

namespace Sweetspot\Domain\User\Repository;

use Sweetspot\Domain\User\User;
use Ramsey\Uuid\UuidInterface;

interface UserRepositoryInterface
{
    public function get(UuidInterface $uuid): User;

    public function store(User $user): void;
}
