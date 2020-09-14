<?php

declare(strict_types=1);

namespace Acme\Application\UseCase\Command\User\SignIn;

use Acme\Domain\User\Exception\InvalidCredentialsException;
use Acme\Domain\User\Repository\GetUserUuidByEmailInterface;
use Acme\Domain\User\Repository\UserRepositoryInterface;
use Acme\Infrastructure\Shared\Bus\Command\CommandHandlerInterface;

class SignInCommandHandler implements CommandHandlerInterface
{
    private UserRepositoryInterface $userStore;

    private GetUserUuidByEmailInterface $userUuidRepository;

    public function __construct(UserRepositoryInterface $userStore, GetUserUuidByEmailInterface $userUuidRepository)
    {
        $this->userStore = $userStore;
        $this->userUuidRepository = $userUuidRepository;
    }

    public function __invoke(SignInCommand $command): void
    {
        $uuid = $this->userUuidRepository->getUuidByEmail($command->email());

        if (null === $uuid) {
            throw new InvalidCredentialsException();
        }

        $user = $this->userStore->get($uuid);

        $user->signIn($command->plainPassword());

        $this->userStore->store($user);
    }
}
