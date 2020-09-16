<?php

declare(strict_types=1);

namespace Acme\Application\UseCase\Command\Order\CreateOrder;

use Acme\Domain\Order\Order;
use Acme\Domain\Order\Repository\OrderRepositoryInterface;
use Acme\Infrastructure\Shared\Bus\Command\CommandHandlerInterface;
use Acme\UI\Http\Rest\Presentation\Order\OrderView;

class CreateOrderCommandHandler implements CommandHandlerInterface
{
    private OrderRepositoryInterface $orderStore;

    public function __construct(OrderRepositoryInterface $orderStore)
    {
        $this->orderStore = $orderStore;
    }

    public function __invoke(CreateOrderCommand $command)
    {
        $order = Order::create($command->getNumber(), $command->getState(), $command->getTotal());

        $this->orderStore->store($order);

        /** @TODO Think about this line because it breaks DDD */
        return OrderView::create($order);
    }
}
