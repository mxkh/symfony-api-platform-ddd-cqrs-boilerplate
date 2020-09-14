<?php

namespace Acme\Domain\User\Repository;

use Acme\Domain\Shared\Query\Exception\NotFoundException;
use Acme\Domain\User\User;
use Acme\Domain\User\ValueObject\Email;
use Doctrine\ORM\NonUniqueResultException;

interface GetUserByEmailInterface
{
    /**
     * @param Email $email
     *
     * @return User|object
     * @throws NonUniqueResultException
     * @throws NotFoundException
     */
    public function oneByEmail(Email $email): User;
}
