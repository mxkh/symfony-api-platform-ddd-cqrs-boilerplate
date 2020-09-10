<?php

declare(strict_types=1);

namespace Sweetspot\Domain\User\ValueObject\Auth;

use Sweetspot\Domain\User\ValueObject\Email;

final class Credentials
{
    public Email $email;

    public HashedPassword $password;

    public function __construct(Email $email, HashedPassword $password)
    {
        $this->email = $email;
        $this->password = $password;
    }
}
