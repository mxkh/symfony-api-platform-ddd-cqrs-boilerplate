<?php

declare(strict_types=1);

namespace Acme\Application\UseCase\Query;

use ApiPlatform\Core\DataProvider\Pagination;

class CollectionQueryFactory
{
    private array $collectionOptions;

    private Pagination $pagination;

    public function __construct(array $collectionOptions, Pagination $pagination)
    {
        /**
         * Extracted from {@see \ApiPlatform\Core\DataProvider\Pagination}
         */
        $this->collectionOptions = \array_merge([
            'page_parameter_name' => 'page',
            'items_per_page_parameter_name' => 'itemsPerPage',
        ], $collectionOptions);

        $this->pagination = $pagination;
    }

    public function createCollectionQuery(string $queryClass, array $context): CollectionQuery
    {
        if (!\is_a($queryClass, CollectionQuery::class, true)) {
            throw new \InvalidArgumentException(\sprintf('%s must be an instance of %s', $queryClass, CollectionQuery::class));
        }

        $filtersContext = [
            $this->collectionOptions['page_parameter_name'] => $this->pagination->getPage($context),
            $this->collectionOptions['items_per_page_parameter_name'] => $this->pagination->getLimit($queryClass::resourceClass(), $queryClass::collectionOperationName(), $context),
        ];

        $queryContext = $context;

        $queryContext['filters'] = \array_merge($context['filters'] ?? [], $filtersContext);

        return $queryClass::createWithContext($queryContext);
    }
}
