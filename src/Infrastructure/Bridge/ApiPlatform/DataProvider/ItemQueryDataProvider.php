<?php

declare(strict_types=1);

namespace Acme\Infrastructure\Bridge\ApiPlatform\DataProvider;

use ApiPlatform\Core\DataProvider\DenormalizedIdentifiersAwareItemDataProviderInterface;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;

class ItemQueryDataProvider implements DenormalizedIdentifiersAwareItemDataProviderInterface, RestrictedDataProviderInterface
{
    public function getItem(string $resourceClass, $id, string $operationName = null, array $context = [])
    {
        // TODO: Implement getItem() method.
    }

    public function supports(string $resourceClass, string $operationName = null, array $context = []): bool
    {
        return false;
    }
}
