<?php

declare(strict_types=1);

namespace Acme\Infrastructure\Shared\Bus;

use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Throwable;

trait MessageBusExceptionTrait
{
    /** @throws Throwable */
    public function throwException(HandlerFailedException $exception): void
    {
        while ($exception instanceof HandlerFailedException) {
            $exception = $exception->getPrevious();
        }

        throw $exception;
    }
}
