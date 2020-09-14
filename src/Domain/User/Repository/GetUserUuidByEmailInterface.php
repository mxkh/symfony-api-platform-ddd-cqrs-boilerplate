<?php

declare(strict_types=1);

namespace Acme\Domain\User\Repository;

use Acme\Domain\User\ValueObject\Email;
use Doctrine\ORM\NonUniqueResultException;
use Ramsey\Uuid\UuidInterface;

interface GetUserUuidByEmailInterface
{
    /**
     * @param Email $email
     *
     * @return UuidInterface|null
     * @throws NonUniqueResultException
     */
    public function getUuidByEmail(Email $email): ?UuidInterface;
}
