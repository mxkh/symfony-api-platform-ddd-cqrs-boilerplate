<?php

declare(strict_types=1);

namespace Acme\Application\UseCase\Command\Organization\CreateOrganization;

use Acme\Domain\Organization\Organization;
use Acme\Domain\Organization\Repository\OrganizationRepositoryInterface;
use Acme\Infrastructure\Shared\Bus\Command\CommandHandlerInterface;

final class CreateOrganizationCommandHandler implements CommandHandlerInterface
{
    private OrganizationRepositoryInterface $organizationRepository;

    public function __construct(
        OrganizationRepositoryInterface $organizationRepository
    ) {
        $this->organizationRepository = $organizationRepository;
    }

    public function __invoke(CreateOrganizationCommand $command): void
    {
        $organization = Organization::create($command->uuid(), $command->profile(), $command->address());

        $this->organizationRepository->store($organization);
    }
}
