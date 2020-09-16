<?php

declare(strict_types=1);

namespace Acme\Domain\Order\Repository;

use Acme\Domain\Order\Order;
use Ramsey\Uuid\Uuid;

interface OrderRepositoryInterface
{
    public function find(Uuid $uuid): ?Order;

    public function store(Order $order);
}
