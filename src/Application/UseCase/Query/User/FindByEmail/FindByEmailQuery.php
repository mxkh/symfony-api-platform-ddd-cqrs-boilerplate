<?php

declare(strict_types=1);

namespace Acme\Application\UseCase\Query\User\FindByEmail;

use Acme\Domain\User\ValueObject\Email;
use Acme\Infrastructure\Shared\Bus\Query\QueryInterface;

class FindByEmailQuery implements QueryInterface
{
    private Email $email;

    public function __construct(string $email)
    {
        $this->email = Email::fromString($email);
    }

    public function email(): Email
    {
        return $this->email;
    }
}
