<?php

namespace Acme\Domain;

interface AggregateRootInterface
{
    public function getAggregateRootId(): string;

    public function clearDomainEvents(): array;
}
