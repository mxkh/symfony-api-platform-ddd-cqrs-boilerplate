<?php

declare(strict_types=1);

namespace Acme\Application\UseCase\Command\Organization\UpdateBillingInformation;

use Acme\Domain\Organization\Repository\OrganizationRepositoryInterface;
use Acme\Domain\User\Repository\UserRepositoryInterface;
use Acme\Domain\User\Specification\Checker\CustomerEmailUniquenessCheckerInterface;
use Acme\Infrastructure\Shared\Bus\Command\CommandHandlerInterface;

final class UpdateBillingInformationCommandHandler implements CommandHandlerInterface
{
    private OrganizationRepositoryInterface $organizationRepository;

    public function __construct(
        OrganizationRepositoryInterface $organizationRepository
    ) {
        $this->organizationRepository = $organizationRepository;
    }

    public function __invoke(UpdateBillingInformationCommand $command): void
    {
        $organization = $this->organizationRepository->get($command->organizationUuid());

        $organization->updateBillingInformation($command->companyName(), $command->email(), $command->phoneNumber(), $command->address());

        $this->organizationRepository->store($organization);
    }
}
