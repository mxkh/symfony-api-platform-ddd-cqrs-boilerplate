<?php

declare(strict_types=1);

namespace Acme\Infrastructure\Organization\Repository;

use Acme\Domain\Organization\Organization;
use Acme\Domain\Organization\Repository\OrganizationRepositoryInterface;
use Acme\Domain\Shared\Query\Exception\NotFoundException;
use Acme\Infrastructure\Shared\Query\Repository\AbstractMysqlRepository;
use Doctrine\ORM\NonUniqueResultException;
use Ramsey\Uuid\UuidInterface;

final class OrganizationStore extends AbstractMysqlRepository implements OrganizationRepositoryInterface
{
    protected function getClass(): string
    {
        return Organization::class;
    }

    /**
     * @param UuidInterface $uuid
     *
     * @return Organization|object
     * @throws NonUniqueResultException
     * @throws NotFoundException
     */
    public function get(UuidInterface $uuid): Organization
    {
        return $this->oneByIdOrException($uuid->getBytes());
    }

    public function store(Organization $organization): void
    {
        $this->register($organization);
    }
}
