<?php

declare(strict_types=1);

namespace Acme\Domain;

use Acme\Domain\Shared\Exception\BusinessRuleValidationException;
use Acme\Domain\Shared\Specification\Rule\BusinessRuleSpecificationInterface;

trait AggregateRootBehaviourTrait
{
    private string $uuid;

    private array $events = [];

    public function getAggregateRootId(): string
    {
        return $this->uuid;
    }

    public function clearDomainEvents(): array
    {
        $recordedEvents = $this->events;
        $this->events = [];

        return $recordedEvents;
    }

    protected function applyDomainEvent(object $event)
    {
        $parts = explode('\\', get_class($event));
        $method = 'apply' . end($parts);
        $this->$method($event);
    }

    protected function addDomainEvent(object $event): void
    {
        $this->applyDomainEvent($event);
        $this->events[] = $event;
    }

    protected static function checkRule(BusinessRuleSpecificationInterface $businessRuleSpecification): void
    {
        if ($businessRuleSpecification->isSatisfiedBy()) {
            return;
        }

        throw new BusinessRuleValidationException($businessRuleSpecification);
    }
}
