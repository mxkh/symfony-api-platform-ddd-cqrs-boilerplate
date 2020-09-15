<?php

declare(strict_types=1);

namespace Acme\Infrastructure\User\Security\Voter;

use Acme\Infrastructure\User\Auth\Auth;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class UserVoter extends Voter
{
    public const CHANGE_EMAIL = 'user_change_email';

    protected function supports(string $attribute, $subject): bool
    {
        if (!\in_array($attribute, [self::CHANGE_EMAIL])) {
            return false;
        }

        if ($subject instanceof UuidInterface) {
            return true;
        }

        if ((\is_string($subject) && Uuid::isValid($subject))) {
            return true;
        }

        return false;
    }

    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token): bool
    {
        $auth = $token->getUser();

        if (!$auth instanceof Auth) {
            // the user must be logged in; if not, deny access
            return false;
        }

        if ($subject instanceof UuidInterface) {
            $uuid = $subject->toString();
        } else {
            /** @var string $uuid */
            $uuid = $subject;
        }

        switch ($attribute) {
            case self::CHANGE_EMAIL:
                return $this->canChangeEmail($uuid, $auth);
        }

        throw new \LogicException('This code should not be reached!');
    }

    private function canChangeEmail(string $uuid, Auth $auth): bool
    {
        return $uuid === $auth->uuid()->toString();
    }
}
