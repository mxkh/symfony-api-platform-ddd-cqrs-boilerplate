<?php

declare(strict_types=1);

namespace Acme\Application\UseCase\Query\User\FindByEmail;

use Acme\Domain\Shared\Query\Exception\NotFoundException;
use Acme\Domain\User\User;
use Acme\Infrastructure\User\Query\Mysql\MysqlReadModelUserRepository;
use Doctrine\ORM\NonUniqueResultException;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class FindByEmailQueryHandler implements MessageHandlerInterface
{
    private MysqlReadModelUserRepository $repository;

    public function __construct(MysqlReadModelUserRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @throws NotFoundException
     * @throws NonUniqueResultException
     */
    public function __invoke(FindByEmailQuery $query): User
    {
        return $this->repository->oneByEmail($query->email());
    }
}
