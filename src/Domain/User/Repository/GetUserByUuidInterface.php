<?php

namespace Acme\Domain\User\Repository;

use Acme\Domain\Shared\Query\Exception\NotFoundException;
use Acme\Domain\User\User;
use Doctrine\ORM\NonUniqueResultException;
use Ramsey\Uuid\UuidInterface;

interface GetUserByUuidInterface
{
    /**
     * @param UuidInterface $uuid
     *
     * @return User|object
     * @throws NotFoundException
     * @throws NonUniqueResultException
     */
    public function oneByUuid(UuidInterface $uuid): User;
}
