<?php

declare(strict_types=1);

namespace Acme\Application\UseCase\Command\User\SignIn;

use Acme\Domain\User\ValueObject\Email;
use Acme\Infrastructure\Shared\Bus\Command\CommandInterface;

class SignInCommand implements CommandInterface
{
    private Email $email;

    private string $plainPassword;

    public function __construct(string $email, string $plainPassword)
    {
        $this->email = Email::fromString($email);
        $this->plainPassword = $plainPassword;
    }

    public function email(): Email
    {
        return $this->email;
    }

    public function plainPassword(): string
    {
        return $this->plainPassword;
    }
}
