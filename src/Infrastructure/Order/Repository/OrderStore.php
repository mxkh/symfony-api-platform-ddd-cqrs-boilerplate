<?php

declare(strict_types=1);

namespace Acme\Infrastructure\Order\Repository;

use Acme\Domain\Order\Order;
use Acme\Domain\Order\Repository\OrderRepositoryInterface;
use Acme\Domain\Shared\Query\Exception\NotFoundException;
use Acme\Infrastructure\Shared\Query\Repository\AbstractMysqlRepository;
use Doctrine\ORM\NonUniqueResultException;
use Ramsey\Uuid\UuidInterface;

class OrderStore extends AbstractMysqlRepository implements OrderRepositoryInterface
{
    protected function getClass(): string
    {
        return Order::class;
    }

    /**
     * @param UuidInterface $uuid
     *
     * @return Order|object
     * @throws NonUniqueResultException
     * @throws NotFoundException
     */
    public function find(UuidInterface $uuid): Order
    {
        return $this->oneByIdOrException($uuid->getBytes());
    }

    public function store(Order $order): void
    {
        $this->register($order);
    }
}
