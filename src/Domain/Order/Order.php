<?php

declare(strict_types=1);

namespace Acme\Domain\Order;

use Acme\Domain\AggregateRootBehaviourTrait;
use Acme\Domain\AggregateRootInterface;
use Acme\Domain\Shared\ValueObject\DateTime;
use Ramsey\Uuid\Uuid;

class Order implements AggregateRootInterface
{
    use AggregateRootBehaviourTrait;

    private string $number;

    private int $total;

    private string $state;

    private DateTime $createdAt;

    private DateTime $updatedAt;

    public static function create(string $number, string $state, int $total)
    {
        $order = new static();
        $order->setUuid(Uuid::uuid4());
        $order->setNumber($number);
        $order->setState($state);
        $order->setTotal($total);
        $order->setCreatedAt(DateTime::now());

        return $order;
    }

    public function setNumber(string $number): void
    {
        $this->number = $number;
    }

    public function getNumber(): string
    {
        return $this->number;
    }

    public function setTotal(int $total): void
    {
        $this->total = $total;
    }

    public function getTotal(): int
    {
        return $this->total;
    }

    public function setState(string $state): void
    {
        $this->state = $state;
    }

    public function getState(): string
    {
        return $this->state;
    }

    public function setCreatedAt(DateTime $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function setUpdatedAt(DateTime $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }
}
