<?php

declare(strict_types=1);

namespace Acme\Application\UseCase\Command\Order\UpdateOrder;

use Acme\Application\UseCase\Command\Order\CreateOrder\CreateOrderInput;
use ApiPlatform\Core\DataTransformer\DataTransformerInterface;
use ApiPlatform\Core\Validator\ValidatorInterface;
use Ramsey\Uuid\UuidInterface;

class UpdateOrderDataTransformer implements DataTransformerInterface
{
    private ValidatorInterface $validator;

    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    public function transform($object, string $to, array $context = [])
    {
        if (!$object instanceof UpdateOrderInput) {
            throw new \InvalidArgumentException(\sprintf('Object is not an instance of %s', UpdateOrderInput::class));
        }

        if (!isset($context['uuid'])) {
            throw new \RuntimeException(\sprintf('Missing uuid value in context'));
        }

        if (($uuid = $context['uuid']) && !$uuid instanceof UuidInterface) {
            throw new \InvalidArgumentException(\sprintf('Given uuid must be an instance of %s', UuidInterface::class));
        }

        $this->validator->validate($object, $context);

        $command = new UpdateOrderCommand();
        $command->setUuid($uuid);
        $command->setNumber($object->number);
        $command->setState($object->state);
        $command->setTotal($object->total);

        return $command;
    }

    public function supportsTransformation($data, string $to, array $context = []): bool
    {
        return UpdateOrderInput::class === ($context['input']['class'] ?? null);
    }
}
