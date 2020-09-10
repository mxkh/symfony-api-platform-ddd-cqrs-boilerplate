<?php

declare(strict_types=1);

namespace Sweetspot\Domain\User\Repository;

use Sweetspot\Domain\User\ValueObject\Email;
use Ramsey\Uuid\UuidInterface;

interface GetUserUuidByEmailInterface
{
    public function getUuidByEmail(Email $email): ?UuidInterface;
}
