<?php

declare(strict_types=1);

namespace Acme\Infrastructure\Shared\Bus\Command;

use Acme\Infrastructure\Shared\Bus\MessageBusExceptionTrait;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Messenger\MessageBusInterface;
use Throwable;

final class CommandBus
{
    use MessageBusExceptionTrait;

    private MessageBusInterface $messageBus;

    public function __construct(MessageBusInterface $messengerBusCommand)
    {
        $this->messageBus = $messengerBusCommand;
    }

    /** @throws Throwable */
    public function handle(CommandInterface $command): void
    {
        try {
            $this->messageBus->dispatch($command);
        } catch (HandlerFailedException $e) {
            $this->throwException($e);
        }
    }
}
