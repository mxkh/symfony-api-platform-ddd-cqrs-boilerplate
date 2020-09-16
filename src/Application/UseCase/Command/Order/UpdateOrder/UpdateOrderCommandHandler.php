<?php

declare(strict_types=1);

namespace Acme\Application\UseCase\Command\Order\UpdateOrder;

use Acme\Domain\Order\Repository\OrderRepositoryInterface;
use Acme\Domain\Shared\Query\Exception\NotFoundException;
use Acme\Domain\Shared\ValueObject\DateTime;
use Acme\Infrastructure\Shared\Bus\Command\CommandHandlerInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class UpdateOrderCommandHandler implements CommandHandlerInterface
{
    private OrderRepositoryInterface $orderStore;

    public function __construct(OrderRepositoryInterface $orderStore)
    {
        $this->orderStore = $orderStore;
    }

    public function __invoke(UpdateOrderCommand $command)
    {
        try {
            $order = $this->orderStore->find($command->getUuid());
        } catch (NotFoundException $e) {
            throw new NotFoundHttpException($e->getMessage());
        }

        $order->setNumber($command->getNumber());
        $order->setState($command->getState());
        $order->setTotal($command->getTotal());
        $order->setUpdatedAt(DateTime::now());

        $this->orderStore->store($order);
    }
}
