<?php

declare(strict_types=1);

namespace Acme\Application\UseCase\Query\User\GetUsers;

use Acme\Application\UseCase\Query\CollectionQueryFactory;
use ApiPlatform\Core\DataTransformer\DataTransformerInterface;

class GetUsersQueryDataTransformer implements DataTransformerInterface
{
    private CollectionQueryFactory $factory;

    public function __construct(CollectionQueryFactory $factory)
    {
        $this->factory = $factory;
    }

    public function supportsTransformation($data, string $to, array $context = []): bool
    {
        return GetUsersQuery::class === ($context['query'] ?? false);
    }

    public function transform($object, string $to, array $context = [])
    {
        return $this->factory->createCollectionQuery(GetUsersQuery::class, $context);
    }
}
