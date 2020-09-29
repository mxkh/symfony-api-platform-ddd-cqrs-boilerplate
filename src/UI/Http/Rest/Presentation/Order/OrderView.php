<?php

declare(strict_types=1);

namespace Acme\UI\Http\Rest\Presentation\Order;

use Acme\Domain\Order\Order;
use Symfony\Component\Serializer\Annotation\Groups;

class OrderView
{
    /**
     * @Groups("order")
     */
    public string $id;

    /**
     * @Groups("order")
     */
    public string $number;

    /**
     * @Groups("order")
     */
    public string $state;

    /**
     * @Groups("order")
     */
    public int $total;

    /**
     * @param object|Order $object
     *
     * @return OrderView
     */
    public static function create(Order $order): self
    {
        $view = new self();
        $view->id = $order->getAggregateRootId();
        $view->number = $order->getNumber();
        $view->state = $order->getState();
        $view->total = $order->getTotal();

        return $view;
    }
}
