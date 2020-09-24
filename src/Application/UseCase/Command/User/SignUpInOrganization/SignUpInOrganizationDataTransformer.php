<?php

declare(strict_types=1);

namespace Acme\Application\UseCase\Command\User\SignUpInOrganization;

use Acme\Infrastructure\Organization\Tenant\Context\TenantContextInterface;
use Acme\Infrastructure\Organization\Tenant\TenantOrganization;
use ApiPlatform\Core\DataTransformer\DataTransformerInterface;
use ApiPlatform\Core\Validator\ValidatorInterface;
use InvalidArgumentException;

final class SignUpInOrganizationDataTransformer implements DataTransformerInterface
{
    private ValidatorInterface $validator;

    private TenantContextInterface $tenantContext;

    public function __construct(
        TenantContextInterface $tenantContext,
        ValidatorInterface $validator
    )
    {
        $this->validator = $validator;
        $this->tenantContext = $tenantContext;
    }

    public function transform($object, string $to, array $context = [])
    {
        if (false === $object instanceof SignUpInOrganizationInput) {
            throw new InvalidArgumentException(sprintf('Object is not an instance of %s', SignUpInOrganizationInput::class));
        }

        $this->validator->validate($object, $context);

        $tenant = $this->tenantContext->getTenant();
        if (false === $tenant instanceof TenantOrganization) {
            throw new InvalidArgumentException(/*todo: must be organization*/);
        }

        return new SignUpInOrganizationCommand(
            $object->uuid,
            $object->email,
            $object->password,
            $tenant->getOrganization()
        );
    }

    public function supportsTransformation($data, string $to, array $context = []): bool
    {
        return SignUpInOrganizationInput::class === ($context['input']['class'] ?? null);
    }
}
