<?php

declare(strict_types=1);

namespace Acme\Application\UseCase\Command\User\ChangeEmail;

use Symfony\Component\Validator\Constraints as Assert;

final class ChangeEmailInput
{
    /**
     * @Assert\Email
     * @Assert\NotBlank
     */
    public string $email;
}
