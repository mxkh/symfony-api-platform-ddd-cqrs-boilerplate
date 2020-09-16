<?php

namespace Acme\Domain;

use Acme\Domain\Shared\Event\DomainEventInterface;

interface AggregateRootInterface
{
    public function getAggregateRootId(): string;

    /**
     * @return array|DomainEventInterface[]
     */
    public function clearDomainEvents(): array;
}
