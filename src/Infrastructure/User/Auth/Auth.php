<?php

declare(strict_types=1);

namespace Acme\Infrastructure\User\Auth;

use Acme\Domain\User\ValueObject\Auth\HashedPassword;
use Acme\Domain\User\ValueObject\Email;
use ApiPlatform\Core\Bridge\Symfony\Validator\Exception\ValidationException;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Security\Core\Encoder\EncoderAwareInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class Auth implements UserInterface, EncoderAwareInterface
{
    private UuidInterface $uuid;

    private Email $email;

    private HashedPassword $hashedPassword;

    private function __construct(UuidInterface $uuid, Email $email, HashedPassword $hashedPassword)
    {
        $this->uuid = $uuid;
        $this->email = $email;
        $this->hashedPassword = $hashedPassword;
    }

    /**
     * @throws ValidationException
     */
    public static function create(UuidInterface $uuid, string $email, string $hashedPassword): self
    {
        return new self($uuid, Email::fromString($email), HashedPassword::fromHash($hashedPassword));
    }

    public function getUsername(): string
    {
        return $this->email->toString();
    }

    public function getPassword(): string
    {
        return $this->hashedPassword->toString();
    }

    public function getRoles(): array
    {
        return [
            'ROLE_USER',
        ];
    }

    public function getSalt(): ?string
    {
        return null;
    }

    public function eraseCredentials(): void
    {
    }

    public function getEncoderName(): string
    {
        return 'bcrypt';
    }

    public function uuid(): UuidInterface
    {
        return $this->uuid;
    }

    public function __toString(): string
    {
        return $this->email->toString();
    }
}
