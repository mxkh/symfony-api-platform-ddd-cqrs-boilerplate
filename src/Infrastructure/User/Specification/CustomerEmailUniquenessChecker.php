<?php

declare(strict_types=1);

namespace Sweetspot\Infrastructure\User\Specification;

use Sweetspot\Domain\User\Exception\EmailAlreadyExistException;
use Sweetspot\Domain\User\Repository\CheckUserByEmailInterface;
use Sweetspot\Domain\User\Specification\Checker\CustomerEmailUniquenessCheckerInterface;
use Sweetspot\Domain\User\ValueObject\Email;
use Doctrine\ORM\NonUniqueResultException;

final class CustomerEmailUniquenessChecker implements CustomerEmailUniquenessCheckerInterface
{
    private CheckUserByEmailInterface $checkUserByEmail;

    public function __construct(CheckUserByEmailInterface $checkUserByEmail)
    {
        $this->checkUserByEmail = $checkUserByEmail;
    }

    public function isUnique(Email $email): bool
    {
        try {
            if ($this->checkUserByEmail->emailExists($email)) {
                throw new EmailAlreadyExistException();
            }
        } catch (NonUniqueResultException $e) {
            throw new EmailAlreadyExistException();
        }

        return true;
    }
}
