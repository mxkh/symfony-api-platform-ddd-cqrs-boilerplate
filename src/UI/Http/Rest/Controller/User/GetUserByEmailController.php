<?php

declare(strict_types=1);

namespace Acme\UI\Http\Rest\Controller\User;

use Acme\Application\UseCase\Query\User\FindByEmail\FindByEmailQuery;
use Acme\UI\Http\Rest\Controller\QueryController;
use Acme\UI\Http\Rest\Presentation\User\UserView;
use Symfony\Component\HttpFoundation\Request;

final class GetUserByEmailController extends QueryController
{
    /**
     * @param Request $request
     *
     * @return mixed
     *
     * @throws \Throwable
     */
    public function __invoke(Request $request, string $email)
    {
        $query = new FindByEmailQuery($email);

        return $this->ask($query);
    }
}
