<?php

namespace Acme\Infrastructure\Bridge\ApiPlatform\DataTransformer;

abstract class AbstractView
{
    abstract public static function create(object $object): self;
}
