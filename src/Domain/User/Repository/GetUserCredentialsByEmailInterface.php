<?php

declare(strict_types=1);

namespace Acme\Domain\User\Repository;

use Acme\Domain\User\ValueObject\Email;

interface GetUserCredentialsByEmailInterface
{
    public function getCredentialsByEmail(Email $email): array;
}
