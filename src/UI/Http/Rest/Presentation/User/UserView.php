<?php

declare(strict_types=1);

namespace Acme\UI\Http\Rest\Presentation\User;

use Acme\Domain\User\User;
use Acme\Infrastructure\Bridge\ApiPlatform\DataTransformer\AbstractView;
use Symfony\Component\Serializer\Annotation\Groups;
use Webmozart\Assert\Assert;

final class UserView extends AbstractView
{
    /**
     * @Groups("profile")
     */
    public string $id;

    /**
     * @Groups("profile")
     */
    public string $email;

    /**
     * @Groups("credentials")
     */
    public string $password;

    /**
     * @param object|User $object
     *
     * @return UserView
     */
    public static function create($object): self
    {
        Assert::isInstanceOf($object, User::class);

        $view = new self();
        $view->id = $object->getAggregateRootId();
        $view->email = $object->getCredentials()->getEmail()->toString();
        $view->password = $object->getCredentials()->getPassword()->toString();

        return $view;
    }
}
