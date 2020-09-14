<?php

declare(strict_types=1);

namespace Acme\Domain\User\Repository;

use Acme\Domain\User\ValueObject\Email;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;

interface CheckUserByEmailInterface
{
    /**
     * @param Email $email
     *
     * @return bool
     * @throws NonUniqueResultException
     * @throws NoResultException
     */
    public function emailExists(Email $email): bool;
}
