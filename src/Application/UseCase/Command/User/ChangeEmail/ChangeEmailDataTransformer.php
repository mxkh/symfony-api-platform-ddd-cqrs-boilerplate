<?php

declare(strict_types=1);

namespace Acme\Application\UseCase\Command\User\ChangeEmail;

use ApiPlatform\Core\DataTransformer\DataTransformerInterface;
use ApiPlatform\Core\Validator\ValidatorInterface;
use Ramsey\Uuid\UuidInterface;

class ChangeEmailDataTransformer implements DataTransformerInterface
{
    private ValidatorInterface $validator;

    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    public function transform($object, string $to, array $context = [])
    {
        if (!$object instanceof ChangeEmailInput) {
            throw new \InvalidArgumentException(\sprintf('Object is not an instance of %s', ChangeEmailInput::class));
        }

        if (!isset($context['uuid'])) {
            throw new \RuntimeException(\sprintf('Missing uuid value in context'));
        }

        if (($uuid = $context['uuid']) && !$uuid instanceof UuidInterface) {
            throw new \InvalidArgumentException(\sprintf('Given uuid must be an instance of %s', UuidInterface::class));
        }

        $this->validator->validate($object, $context);

        return new ChangeEmailCommand($uuid->toString(), $object->email);
    }

    public function supportsTransformation($data, string $to, array $context = []): bool
    {
        return ChangeEmailInput::class === ($context['input']['class'] ?? null);
    }
}
