<?php

declare(strict_types=1);

namespace Sweetspot\Domain\User\Repository;

use Sweetspot\Domain\User\ValueObject\Email;

interface GetUserCredentialsByEmailInterface
{
    public function getCredentialsByEmail(Email $email): array;
}
