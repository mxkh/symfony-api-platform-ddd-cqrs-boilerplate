<?php

declare(strict_types=1);

namespace Acme\Infrastructure\User\Query\Mysql;

use Acme\Domain\User\Repository\CheckUserByEmailInterface;
use Acme\Domain\User\Repository\GetUserByEmailInterface;
use Acme\Domain\User\Repository\GetUserByUuidInterface;
use Acme\Domain\User\Repository\GetUserCredentialsByEmailInterface;
use Acme\Domain\User\Repository\GetUserUuidByEmailInterface;
use Acme\Domain\User\User;
use Acme\Domain\User\ValueObject\Email;
use Acme\Infrastructure\Shared\Query\Repository\AbstractMysqlRepository;
use Doctrine\ORM\AbstractQuery;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

final class MysqlReadModelUserRepository extends AbstractMysqlRepository implements
    CheckUserByEmailInterface,
    GetUserCredentialsByEmailInterface,
    GetUserUuidByEmailInterface,
    GetUserByUuidInterface,
    GetUserByEmailInterface
{
    protected function getClass(): string
    {
        return User::class;
    }

    /**
     * {@inheritDoc}
     */
    public function oneByUuid(UuidInterface $uuid): User
    {
        return $this->oneByIdOrException($uuid->getBytes());
    }

    /**
     * {@inheritDoc}
     */
    public function oneByEmail(Email $email): User
    {
        $qb = $this->repository
            ->createQueryBuilder('user')
            ->where('user.credentials.email = :email')
            ->setParameter('email', $email->toString());

        return $this->oneOrException($qb);
    }

    /**
     * {@inheritDoc}
     */
    public function emailExists(Email $email): bool
    {
        return 0 !== (int)$this->repository
                ->createQueryBuilder('user')
                ->select('count(1)')
                ->where('user.credentials.email = :email')
                ->setParameter('email', (string)$email)
                ->getQuery()
                ->getSingleScalarResult();
    }

    /**
     * {@inheritDoc}
     */
    public function getCredentialsByEmail(Email $email): array
    {
        $user = $this->oneByEmail($email);

        return [
            Uuid::fromString($user->getAggregateRootId()),
            $user->getCredentials()->email->toString(),
            $user->getCredentials()->password->toString(),
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function getUuidByEmail(Email $email): ?UuidInterface
    {
        $userId = $this->repository
            ->createQueryBuilder('user')
            ->select('user.uuid')
            ->where('user.credentials.email = :email')
            ->setParameter('email', (string)$email)
            ->getQuery()
            ->setHydrationMode(AbstractQuery::HYDRATE_ARRAY)
            ->getOneOrNullResult();

        return $userId['uuid'] ?? null;
    }
}
