<?php

declare(strict_types=1);

namespace Acme\Domain\User\ValueObject\Auth;

use Acme\Domain\User\ValueObject\Email;

final class Credentials
{
    public Email $email;

    public HashedPassword $password;

    public function __construct(Email $email, HashedPassword $password)
    {
        $this->email = $email;
        $this->password = $password;
    }

    public function getEmail(): Email
    {
        return $this->email;
    }

    public function getPassword(): HashedPassword
    {
        return $this->password;
    }
}
