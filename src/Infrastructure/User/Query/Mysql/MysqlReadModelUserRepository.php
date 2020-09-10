<?php

declare(strict_types=1);

namespace Sweetspot\Infrastructure\User\Query\Mysql;

use Sweetspot\Domain\Shared\Query\Exception\NotFoundException;
use Sweetspot\Domain\User\Repository\CheckUserByEmailInterface;
use Sweetspot\Domain\User\Repository\GetUserCredentialsByEmailInterface;
use Sweetspot\Domain\User\Repository\GetUserUuidByEmailInterface;
use Sweetspot\Domain\User\User;
use Sweetspot\Domain\User\ValueObject\Email;
use Sweetspot\Infrastructure\Shared\Query\Repository\AbstractMysqlRepository;
use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Ramsey\Uuid\UuidInterface;

final class MysqlReadModelUserRepository extends AbstractMysqlRepository implements
    CheckUserByEmailInterface,
    GetUserCredentialsByEmailInterface,
    GetUserUuidByEmailInterface
{
    protected function getClass(): string
    {
        return User::class;
    }

    /**
     * @param UuidInterface $uuid
     *
     * @return User|object
     * @throws NotFoundException
     * @throws NonUniqueResultException
     */
    public function oneByUuid(UuidInterface $uuid): User
    {
        return $this->oneById($uuid->getBytes());
    }

    /**
     * @param Email $email
     *
     * @return User|object
     * @throws NonUniqueResultException
     * @throws NotFoundException
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
     * @param Email $email
     *
     * @return bool
     * @throws NonUniqueResultException
     * @throws NoResultException
     */
    public function emailExists(Email $email): bool
    {
        return 0 !== (int) $this->repository
                ->createQueryBuilder('user')
                ->select('count(1)')
                ->where('user.credentials.email = :email')
                ->setParameter('email', (string) $email)
                ->getQuery()
                ->getSingleScalarResult();
    }

    /**
     * @param Email $email
     *
     * @return array
     * @throws NonUniqueResultException
     * @throws NotFoundException
     */
    public function getCredentialsByEmail(Email $email): array
    {
        $user = $this->oneByEmail($email);

        return [
            $user->uuid(),
            $user->email(),
            $user->encodedPassword(),
        ];
    }

    /**
     * @param Email $email
     *
     * @return UuidInterface|null
     * @throws NonUniqueResultException
     */
    public function getUuidByEmail(Email $email): ?UuidInterface
    {
        $userId = $this->repository
            ->createQueryBuilder('user')
            ->select('user.uuid')
            ->where('user.credentials.email = :email')
            ->setParameter('email', (string) $email)
            ->getQuery()
            ->setHydrationMode(AbstractQuery::HYDRATE_ARRAY)
            ->getOneOrNullResult();

        return $userId['uuid'] ?? null;
    }
}
