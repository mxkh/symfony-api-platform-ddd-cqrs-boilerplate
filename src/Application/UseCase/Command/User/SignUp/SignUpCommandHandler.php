<?php

declare(strict_types=1);

namespace Acme\Application\UseCase\Command\User\SignUp;

use Acme\Domain\User\Repository\UserRepositoryInterface;
use Acme\Domain\User\Specification\Checker\CustomerEmailUniquenessCheckerInterface;
use Acme\Domain\User\User;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

final class SignUpCommandHandler implements MessageHandlerInterface
{
    private UserRepositoryInterface $userRepository;

    private CustomerEmailUniquenessCheckerInterface $customerEmailUniquenessChecker;

    public function __construct(
        UserRepositoryInterface $userRepository,
        CustomerEmailUniquenessCheckerInterface $customerEmailUniquenessChecker
    ) {
        $this->userRepository = $userRepository;
        $this->customerEmailUniquenessChecker = $customerEmailUniquenessChecker;
    }

    public function __invoke(SignUpCommand $command): void
    {
        $user = User::create($command->uuid(), $command->credentials(), $this->customerEmailUniquenessChecker);

        $this->userRepository->store($user);
    }
}
