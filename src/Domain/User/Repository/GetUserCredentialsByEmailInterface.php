<?php

declare(strict_types=1);

namespace Acme\Domain\User\Repository;

use Acme\Domain\Shared\Query\Exception\NotFoundException;
use Acme\Domain\User\ValueObject\Email;
use Doctrine\ORM\NonUniqueResultException;

interface GetUserCredentialsByEmailInterface
{
    /**
     * @param Email $email
     *
     * @return array
     * @throws NonUniqueResultException
     * @throws NotFoundException
     */
    public function getCredentialsByEmail(Email $email): array;
}
