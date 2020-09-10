<?php

declare(strict_types=1);

namespace Sweetspot\Infrastructure\User\Repository;

use Sweetspot\Domain\Shared\Query\Exception\NotFoundException;
use Sweetspot\Domain\User\Repository\UserRepositoryInterface;
use Sweetspot\Domain\User\User;
use Sweetspot\Infrastructure\Shared\Query\Repository\AbstractMysqlRepository;
use Doctrine\ORM\NonUniqueResultException;
use Ramsey\Uuid\UuidInterface;

final class UserStore extends AbstractMysqlRepository implements UserRepositoryInterface
{
    protected function getClass(): string
    {
        return User::class;
    }

    /**
     * @param UuidInterface $uuid
     *
     * @return User|object
     * @throws NonUniqueResultException
     * @throws NotFoundException
     */
    public function get(UuidInterface $uuid): User
    {
        return $this->oneById($uuid->getBytes());
    }

    public function store(User $user): void
    {
        $this->register($user);
    }
}
