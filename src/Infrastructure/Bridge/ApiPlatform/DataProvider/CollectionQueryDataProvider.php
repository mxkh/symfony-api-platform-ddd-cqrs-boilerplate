<?php

declare(strict_types=1);

namespace Acme\Infrastructure\Bridge\ApiPlatform\DataProvider;

use Acme\Infrastructure\Shared\Bus\Query\QueryBus;
use Acme\Infrastructure\Shared\Bus\Query\QueryInterface;
use ApiPlatform\Core\DataProvider\ContextAwareCollectionDataProviderInterface;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use ApiPlatform\Core\DataTransformer\DataTransformerInterface;
use ApiPlatform\Core\Exception\ResourceClassNotFoundException;
use ApiPlatform\Core\Exception\ResourceClassNotSupportedException;
use ApiPlatform\Core\Metadata\Resource\Factory\ResourceMetadataFactoryInterface;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Messenger\Stamp\HandledStamp;
use Throwable;

class CollectionQueryDataProvider implements ContextAwareCollectionDataProviderInterface, RestrictedDataProviderInterface
{
    private QueryBus $queryBus;

    private ResourceMetadataFactoryInterface $resourceMetadataFactory;

    /** @var DataTransformerInterface[]|iterable */
    private $dataTransformers;

    public function __construct(
        QueryBus $queryBus,
        ResourceMetadataFactoryInterface $resourceMetadataFactory,
        iterable $dataTransformers = []
    ) {
        $this->queryBus = $queryBus;
        $this->resourceMetadataFactory = $resourceMetadataFactory;
        $this->dataTransformers = $dataTransformers;
    }

    public function supports(string $resourceClass, string $operationName = null, array $context = []): bool
    {
        try {
            $resourceMetadata = $this->resourceMetadataFactory->create($resourceClass);
            $this->getDataTransformer($resourceClass, $context);

            if (false !== $resourceMetadata->getCollectionOperationAttribute($operationName, 'query', false, true)) {
                return true;
            }
        } catch (ResourceClassNotFoundException | ResourceClassNotSupportedException $e) {
            return false;
        }

        return false;
    }

    public function getCollection(string $resourceClass, string $operationName = null, array $context = [])
    {
        $resourceMetadata = $this->resourceMetadataFactory->create($resourceClass);
        $context['query'] = $resourceMetadata->getCollectionOperationAttribute($operationName, 'query', false, true);

        $dataTransformer = $this->getDataTransformer($resourceClass, $context);

        $query = $dataTransformer->transform((object) [], $resourceClass, $context);

        if (!$query instanceof QueryInterface) {
            throw new ResourceClassNotSupportedException(\sprintf('Given resource does not implement %s', QueryInterface::class));
        }

        return $this->queryBus->handle($query);
    }

    /**
     * @throws ResourceClassNotSupportedException
     */
    protected function getDataTransformer(string $to, array $context = []): DataTransformerInterface
    {
        foreach ($this->dataTransformers as $dataTransformer) {
            if ($dataTransformer->supportsTransformation([], $to, $context)) {
                return $dataTransformer;
            }
        }

        throw new ResourceClassNotSupportedException(\sprintf('Given resource cannot be converted to %s', QueryInterface::class));
    }
}
