<?php

declare(strict_types=1);

namespace Acme\Infrastructure\Bridge\ApiPlatform\DataTransformer;

use ApiPlatform\Core\DataTransformer\DataTransformerInterface;

final class ViewDataTransformer implements DataTransformerInterface
{
    public function transform($object, string $to, array $context = [])
    {
        return $to::create($object);
    }

    public function supportsTransformation($data, string $to, array $context = []): bool
    {
        return is_subclass_of($to, AbstractView::class);
    }
}
