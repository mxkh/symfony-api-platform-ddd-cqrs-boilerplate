<?php

declare(strict_types=1);

namespace Acme\Domain\User\Repository;

use Acme\Domain\User\ValueObject\Email;
use Ramsey\Uuid\UuidInterface;

interface GetUserUuidByEmailInterface
{
    public function getUuidByEmail(Email $email): ?UuidInterface;
}
