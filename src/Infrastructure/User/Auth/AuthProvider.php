<?php

declare(strict_types=1);

namespace Acme\Infrastructure\User\Auth;

use Acme\Domain\Shared\Query\Exception\NotFoundException;
use Acme\Domain\User\ValueObject\Email;
use Acme\Infrastructure\User\Query\Mysql\MysqlReadModelUserRepository;
use ApiPlatform\Core\Bridge\Symfony\Validator\Exception\ValidationException;
use Doctrine\ORM\NonUniqueResultException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class AuthProvider implements UserProviderInterface
{
    private MysqlReadModelUserRepository $userReadModelRepository;

    public function __construct(MysqlReadModelUserRepository $userReadModelRepository)
    {
        $this->userReadModelRepository = $userReadModelRepository;
    }

    /**
     * @return Auth|UserInterface
     * @throws NonUniqueResultException
     *
     */
    public function loadUserByUsername(string $email)
    {
        try {
            $repository = $this->userReadModelRepository;

            $credentials = $repository->getCredentialsByEmail(Email::fromString($email));
            [$uuid, $email, $hashedPassword] = $credentials;
        } catch (ValidationException | NotFoundException $exception) {
            throw new UsernameNotFoundException(\sprintf('User "%s" not found.', $email), 0, $exception);
        }

        return Auth::create($uuid, $email, $hashedPassword);
    }

    /**
     * @throws NotFoundException
     * @throws \InvalidArgumentException
     * @throws NonUniqueResultException
     */
    public function refreshUser(UserInterface $user): UserInterface
    {
        return $this->loadUserByUsername($user->getUsername());
    }

    public function supportsClass(string $class): bool
    {
        return Auth::class === $class;
    }
}
