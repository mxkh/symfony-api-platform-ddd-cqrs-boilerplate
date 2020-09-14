<?php

declare(strict_types=1);

namespace Acme\Infrastructure\Shared\Query\Repository;

use Acme\Domain\Shared\Query\Exception\NotFoundException;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\QueryBuilder;

abstract class AbstractMysqlRepository
{
    protected EntityRepository $repository;

    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->setRepository($this->getClass());
    }

    abstract protected function getClass(): string;

    public function register(object $entity): void
    {
        $this->entityManager->persist($entity);
        $this->apply();
    }

    public function apply(): void
    {
        $this->entityManager->flush();
    }

    /**
     * @param string $id
     *
     * @return object
     * @throws NonUniqueResultException
     * @throws NotFoundException
     */
    protected function oneByIdOrException(string $id):object
    {
        $qb = $this->repository
            ->createQueryBuilder('user')
            ->where('user.uuid = :uuid')
            ->setParameter('uuid', $id);

        return $this->oneOrException($qb);
    }

    /**
     * @param QueryBuilder $queryBuilder
     *
     * @return object
     * @throws NotFoundException
     * @throws NonUniqueResultException
     */
    protected function oneOrException(QueryBuilder $queryBuilder): object
    {
        $entity = $queryBuilder
            ->getQuery()
            ->getOneOrNullResult();

        if (null === $entity) {
            throw new NotFoundException();
        }

        return $entity;
    }

    private function setRepository(string $model): void
    {
        $objectRepository = $this->entityManager->getRepository($model);
        $this->repository = $objectRepository;
    }
}
