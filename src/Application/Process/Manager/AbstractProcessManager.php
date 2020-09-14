<?php

declare(strict_types=1);

namespace Acme\Application\Process\Manager;

abstract class AbstractProcessManager
{
    protected abstract function process(object $data): void;
}
