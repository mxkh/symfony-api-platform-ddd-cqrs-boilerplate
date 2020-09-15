<?php

declare(strict_types=1);

namespace Acme\Application\UseCase\Command\User\ChangeEmail;

use Acme\Domain\User\Repository\UserRepositoryInterface;
use Acme\Domain\User\Specification\Checker\CustomerEmailUniquenessCheckerInterface;
use Acme\Infrastructure\Shared\Bus\Command\CommandHandlerInterface;

class ChangeEmailCommandHandler implements CommandHandlerInterface
{
    private UserRepositoryInterface $userRepository;

    private CustomerEmailUniquenessCheckerInterface $uniqueEmailSpecification;

    public function __construct(
        UserRepositoryInterface $userRepository,
        CustomerEmailUniquenessCheckerInterface $uniqueEmailSpecification
    ) {
        $this->userRepository = $userRepository;
        $this->uniqueEmailSpecification = $uniqueEmailSpecification;
    }

    public function __invoke(ChangeEmailCommand $command): void
    {
        $user = $this->userRepository->get($command->userUuid());

        $user->changeEmail($command->email(), $this->uniqueEmailSpecification);

        $this->userRepository->store($user);
    }
}
