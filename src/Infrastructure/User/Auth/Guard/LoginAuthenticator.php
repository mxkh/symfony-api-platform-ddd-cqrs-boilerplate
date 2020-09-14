<?php

declare(strict_types=1);

namespace Acme\Infrastructure\User\Auth\Guard;

use Acme\Application\UseCase\Command\User\SignIn\SignInCommand;
use Acme\Domain\Shared\Query\Exception\NotFoundException;
use Acme\Domain\User\Exception\InvalidCredentialsException;
use Acme\Domain\User\Repository\GetUserByEmailInterface;
use Acme\Domain\User\User;
use Acme\Domain\User\ValueObject\Email;
use Acme\Infrastructure\Shared\Bus\Command\CommandBus;
use Acme\Infrastructure\Shared\Bus\Query\QueryBus;
use Acme\Infrastructure\User\Auth\Auth;
use ApiPlatform\Core\Bridge\Symfony\Validator\Exception\ValidationException;
use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\Authenticator\AbstractFormLoginAuthenticator;

final class LoginAuthenticator extends AbstractFormLoginAuthenticator
{
    private const LOGIN = 'login';

    private const SUCCESS_REDIRECT = 'profile';

    private CommandBus $bus;

    private QueryBus $queryBus;

    private UrlGeneratorInterface $router;

    private GetUserByEmailInterface $getUserByEmail;

    public function __construct(
        CommandBus $commandBus,
        QueryBus $queryBus,
        UrlGeneratorInterface $router,
        GetUserByEmailInterface $getUserByEmail
    ) {
        $this->bus = $commandBus;
        $this->router = $router;
        $this->queryBus = $queryBus;
        $this->getUserByEmail = $getUserByEmail;
    }

    public function supports(Request $request): bool
    {
        return $request->getPathInfo() === $this->router->generate(self::LOGIN) && $request->isMethod('POST');
    }

    public function getCredentials(Request $request): array
    {
        $credentials = [
            'email' => $request->request->get('_email'),
            'password' => $request->request->get('_password'),
        ];

        $request->getSession()->set(
            Security::LAST_USERNAME,
            $credentials['email']
        );

        return $credentials;
    }

    public function getUser($credentials, UserProviderInterface $userProvider): ?UserInterface
    {
        try {
            $email = $credentials['email'];
            $plainPassword = $credentials['password'];

            $signInCommand = new SignInCommand($email, $plainPassword);

            $this->bus->handle($signInCommand);

            /** @var User $user */
            // $user = $this->queryBus->handle(new FindByEmailQuery($email));
            $user = $this->getUserByEmail->oneByEmail(Email::fromString($email));

            $uuid = Uuid::fromString($user->getAggregateRootId());
            $email = $user->getCredentials()->email->toString();
            $password = $user->getCredentials()->password->toString();

            return Auth::create($uuid, $email, $password);
        } catch (ValidationException | InvalidCredentialsException | NotFoundException | \InvalidArgumentException $exception) {
            throw new BadCredentialsException($exception->getMessage(), 0, $exception);
        }
    }

    public function checkCredentials($credentials, UserInterface $user): bool
    {
        // Credentials have already been checked in getUser method
        return true;
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey): ?Response
    {
        return new RedirectResponse($this->router->generate(self::SUCCESS_REDIRECT));
    }

    protected function getLoginUrl(): string
    {
        return $this->router->generate(self::LOGIN);
    }
}
