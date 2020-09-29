<?php

declare(strict_types=1);

namespace Acme\Application\UseCase\Command\Order\CreateOrder;

use Acme\Infrastructure\Shared\Bus\Command\CommandInterface;

class CreateOrderCommand implements CommandInterface
{
    private string $number;
    private string $state;
    private int $total;

    public function __construct(string $number, string $state, int $total)
    {
        $this->number = $number;
        $this->state = $state;
        $this->total = $total;
    }

    public function getNumber(): string
    {
        return $this->number;
    }

    public function getState(): string
    {
        return $this->state;
    }

    public function getTotal(): int
    {
        return $this->total;
    }
}
