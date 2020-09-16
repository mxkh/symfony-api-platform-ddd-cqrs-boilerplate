<?php

declare(strict_types=1);

namespace Acme\Application\UseCase\Command\Order\CreateOrder;

use ApiPlatform\Core\DataTransformer\DataTransformerInterface;
use ApiPlatform\Core\Validator\ValidatorInterface;

class CreateOrderDataTransformer implements DataTransformerInterface
{
    private ValidatorInterface $validator;

    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    public function transform($object, string $to, array $context = [])
    {
        if (!$object instanceof CreateOrderInput) {
            throw new \InvalidArgumentException(\sprintf('Object is not an instance of %s', CreateOrderInput::class));
        }

        $this->validator->validate($object, $context);

        return new CreateOrderCommand(
            $object->number,
            $object->state,
            $object->total
        );
    }

    public function supportsTransformation($data, string $to, array $context = []): bool
    {
        return CreateOrderInput::class === ($context['input']['class'] ?? null);
    }
}
