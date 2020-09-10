<?php

namespace Sweetspot\Domain;

interface AggregateRootInterface
{
    public function getAggregateRootId(): string;

    public function clearDomainEvents(): array;
}
