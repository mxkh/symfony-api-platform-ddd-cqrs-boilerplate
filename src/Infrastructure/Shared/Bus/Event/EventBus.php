<?php

declare(strict_types=1);

namespace Acme\Infrastructure\Shared\Bus\Event;

use Acme\Infrastructure\Shared\Bus\MessageBusExceptionTrait;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Messenger\MessageBusInterface;
use Throwable;

final class EventBus
{
    use MessageBusExceptionTrait;

    private MessageBusInterface $messageBus;

    public function __construct(MessageBusInterface $messengerBusEventAsync)
    {
        $this->messageBus = $messengerBusEventAsync;
    }

    /** @throws Throwable */
    public function handle(EventInterface $command): void
    {
        try {
            $this->messageBus->dispatch($command);
        } catch (HandlerFailedException $e) {
            $this->throwException($e);
        }
    }
}
