<?php

declare(strict_types=1);

namespace Acme\UI\Http\Rest\Presentation\User;

use Acme\Domain\User\User;
use Acme\Infrastructure\Bridge\ApiPlatform\DataTransformer\AbstractView;
use Symfony\Component\Serializer\Annotation\Groups;
use Webmozart\Assert\Assert;

final class UserProfileView extends AbstractView
{
    public string $id;

    public string $login;

    /**
     * @param object|UserProfileView $object
     *
     * @return UserView
     */
    public static function create($object): self
    {
        Assert::isInstanceOf($object, User::class);

        $view = new self();
        $view->id = $object->getAggregateRootId();
        $view->login = $object->getCredentials()->getEmail()->toString();

        return $view;
    }
}
