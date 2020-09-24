<?php

declare(strict_types=1);

namespace Acme\Application\UseCase\Command\Organization\CreateOrganization;

use ApiPlatform\Core\DataTransformer\DataTransformerInterface;
use ApiPlatform\Core\Validator\ValidatorInterface;

final class CreateOrganizationInputDataTransformer implements DataTransformerInterface
{
    private ValidatorInterface $validator;

    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    public function transform($object, string $to, array $context = [])
    {
        if (false === $object instanceof CreateOrganizationInput) {
            throw new \InvalidArgumentException(\sprintf('Object is not an instance of %s',
                CreateOrganizationInput::class));
        }

        $this->validator->validate($object, $context);

        return new CreateOrganizationCommand(
            $object->uuid,
            $object->name,
            $object->description,
            $object->shortDescription,
            $object->addressLine1,
            $object->addressLine2,
            $object->city,
            $object->region,
            $object->country,
            $object->zipCode
        );
    }

    public function supportsTransformation($data, string $to, array $context = []): bool
    {
        return CreateOrganizationInput::class === ($context['input']['class'] ?? null);
    }
}
