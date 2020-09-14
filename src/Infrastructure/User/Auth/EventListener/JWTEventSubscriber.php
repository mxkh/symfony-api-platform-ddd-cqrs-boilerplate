<?php

declare(strict_types=1);

namespace Acme\Infrastructure\User\Auth\EventListener;

use Acme\Application\UseCase\Command\User\SignIn\SignInCommand;
use Acme\Infrastructure\Shared\Bus\Command\CommandBus;
use Acme\Infrastructure\User\Auth\Auth;
use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTCreatedEvent;
use Lexik\Bundle\JWTAuthenticationBundle\Events;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RequestStack;

class JWTEventSubscriber implements EventSubscriberInterface
{
    private CommandBus $commandBus;

    private LoggerInterface $logger;

    private RequestStack $requestStack;

    public function __construct(
        CommandBus $commandBus,
        LoggerInterface $logger,
        RequestStack $requestStack
    ) {
        $this->commandBus = $commandBus;
        $this->logger = $logger;
        $this->requestStack = $requestStack;
    }

    public static function getSubscribedEvents()
    {
        return [
            Events::JWT_CREATED => 'onJWTCreated',
        ];
    }

    public function onJWTCreated(JWTCreatedEvent $event): void
    {
        $user = $event->getUser();

        if ($user instanceof Auth && $request = $this->requestStack->getMasterRequest()) {
            $encodedContent = \json_decode(
                (string)$request->getContent(),
                true,
                512,
                \JSON_THROW_ON_ERROR
            );
            $command = new SignInCommand($user->getUsername(), $encodedContent['password']);

            try {
                $this->commandBus->handle($command);
            } catch (\JsonException $e) {
                $this->logger->error($e->getMessage());
                throw $e;
            } catch (\Throwable $e) {
                $this->logger->error($e->getMessage(), [
                    'command' => SignInCommand::class,
                    'payload' => [
                        'email' => $user->getUsername(),
                    ],
                ]);
                throw $e;
            }
        }
    }
}
