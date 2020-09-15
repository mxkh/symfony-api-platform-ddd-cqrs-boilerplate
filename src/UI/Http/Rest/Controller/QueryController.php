<?php

declare(strict_types=1);

namespace Acme\UI\Http\Rest\Controller;

use Acme\Infrastructure\Shared\Bus\Query\QueryBus;
use Acme\Infrastructure\Shared\Bus\Query\QueryInterface;

abstract class QueryController
{
    private QueryBus $queryBus;

    public function __construct(QueryBus $queryBus)
    {
        $this->queryBus = $queryBus;
    }

    /**
     * @param QueryInterface $query
     *
     * @return mixed
     *
     * @throws \Throwable
     */
    protected function ask(QueryInterface $query)
    {
        return $this->queryBus->handle($query);
    }
}
