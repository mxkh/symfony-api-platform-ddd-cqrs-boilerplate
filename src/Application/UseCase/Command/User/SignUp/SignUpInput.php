<?php

declare(strict_types=1);

namespace Acme\Application\UseCase\Command\User\SignUp;

use Symfony\Component\Validator\Constraints as Assert;

final class SignUpInput
{
    /**
     * @Assert\Uuid
     * @Assert\NotBlank
     */
    public string $uuid;

    /**
     * @Assert\Email
     * @Assert\NotBlank
     */
    public string $email;

    /**
     * @Assert\NotBlank
     * @Assert\Type("string")
     */
    public string $password;
}
