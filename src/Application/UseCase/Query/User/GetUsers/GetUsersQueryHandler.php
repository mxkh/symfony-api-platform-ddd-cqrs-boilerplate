<?php

declare(strict_types=1);

namespace Acme\Application\UseCase\Query\User\GetUsers;

use Acme\Infrastructure\Shared\Bus\Query\QueryHandlerInterface;
use ApiPlatform\Core\Bridge\Doctrine\Orm\CollectionDataProvider;

class GetUsersQueryHandler implements QueryHandlerInterface
{
    private CollectionDataProvider $provider;

    public function __construct(CollectionDataProvider $provider)
    {
        $this->provider = $provider;
    }

    public function __invoke(GetUsersQuery $data): iterable
    {
        return $this->provider->getCollection(
            $data->resourceClass(),
            $data->collectionOperationName(),
            $data->context()
        );
    }

}
