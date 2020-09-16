<?php

declare(strict_types=1);

namespace Acme\Infrastructure\Bridge\ApiPlatform\Event;

use Acme\Infrastructure\Bridge\Doctrine\Event\DomainEventCollector;
use Acme\Infrastructure\Shared\Bus\Event\EventBus;
use Acme\Infrastructure\Shared\Bus\MessageBusExceptionTrait;
use Symfony\Component\Console\ConsoleEvents;
use Symfony\Component\Console\Event\ConsoleTerminateEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\TerminateEvent;
use Symfony\Component\HttpKernel\KernelEvents;

final class DomainEventDispatcher implements EventSubscriberInterface
{
    use MessageBusExceptionTrait;

    private DomainEventCollector $collector;

    private EventBus $eventBus;

    public function __construct(DomainEventCollector $collector, EventBus $eventBus)
    {
        $this->collector = $collector;
        $this->eventBus = $eventBus;
    }

    public function onKernelTerminate(TerminateEvent $event): void
    {
        $this->dispatch();
    }

    public function onConsoleTerminate(ConsoleTerminateEvent $event): void
    {
        $this->dispatch();
    }

    private function dispatch(): void
    {
        $entities = $this->collector->getEntities();

        if ($entities->isEmpty()) {
            return;
        }

        foreach ($entities as $entity) {
            foreach ($entity->clearDomainEvents() as $domainEvent) {
                $this->eventBus->handle($domainEvent);
            }
        }
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::TERMINATE => 'onKernelTerminate',
            ConsoleEvents::TERMINATE => 'onConsoleTerminate',
        ];
    }
}
