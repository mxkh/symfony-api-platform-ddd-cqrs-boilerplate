<?php

declare(strict_types=1);

namespace Acme\Application\UseCase\Command\Order\CreateOrder;

use Symfony\Component\Validator\Constraints as Assert;

class CreateOrderInput
{
    /**
     * @Assert\NotBlank
     * @Assert\Type("string")
     */
    public string $number;

    /**
     * @Assert\NotBlank
     * @Assert\Type("string")
     */
    public string $state;

    /**
     * @Assert\NotBlank
     * @Assert\Type("int")
     */
    public int $total;
}
