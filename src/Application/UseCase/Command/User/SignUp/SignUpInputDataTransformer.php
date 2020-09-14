<?php

declare(strict_types=1);

namespace Acme\Application\UseCase\Command\User\SignUp;

use ApiPlatform\Core\DataTransformer\DataTransformerInterface;
use ApiPlatform\Core\Validator\ValidatorInterface;

final class SignUpInputDataTransformer implements DataTransformerInterface
{
    private ValidatorInterface $validator;

    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    public function transform($object, string $to, array $context = [])
    {
        if (!$object instanceof SignUpInput) {
            throw new \InvalidArgumentException(\sprintf('Object is not an instance of %s', SignUpInput::class));
        }

        $this->validator->validate($object, $context);

        return new SignUpCommand(
            $object->uuid,
            $object->email,
            $object->password
        );
    }

    public function supportsTransformation($data, string $to, array $context = []): bool
    {
        return SignUpInput::class === ($context['input']['class'] ?? null);
    }
}
