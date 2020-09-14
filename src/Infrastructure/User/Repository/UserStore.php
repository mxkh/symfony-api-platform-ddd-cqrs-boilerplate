<?php

declare(strict_types=1);

namespace Acme\Infrastructure\User\Repository;

use Acme\Domain\Shared\Query\Exception\NotFoundException;
use Acme\Domain\User\Repository\UserRepositoryInterface;
use Acme\Domain\User\User;
use Acme\Infrastructure\Shared\Query\Repository\AbstractMysqlRepository;
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
        return $this->oneByIdOrException($uuid->getBytes());
    }

    public function store(User $user): void
    {
        $this->register($user);
    }
}
