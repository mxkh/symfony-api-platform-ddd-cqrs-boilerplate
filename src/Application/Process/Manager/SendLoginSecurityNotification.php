<?php

declare(strict_types=1);

namespace Acme\Application\Process\Manager;

use Acme\Domain\User\Event\UserSignedIn;
use Acme\Infrastructure\Shared\Bus\Event\EventHandlerInterface;

final class SendLoginSecurityNotification implements EventHandlerInterface
{
    public function __invoke(UserSignedIn $event):void
    {
        return;
    }
}
