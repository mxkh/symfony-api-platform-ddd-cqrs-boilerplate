<?php

declare(strict_types=1);

namespace Acme\Infrastructure\Bridge\ApiPlatform\Serializer;

use ApiPlatform\Core\Serializer\SerializerContextBuilderInterface;
use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpFoundation\Request;

class SerializerContextBuilder implements SerializerContextBuilderInterface
{
    private SerializerContextBuilderInterface $decorated;

    public function __construct(SerializerContextBuilderInterface $decorated)
    {
        $this->decorated = $decorated;
    }

    /**
     * {@inheritdoc}
     */
    public function createFromRequest(Request $request, bool $normalization, array $extractedAttributes = null): array
    {
        $context = $this->decorated->createFromRequest($request, $normalization, $extractedAttributes);

        // Populate context with uuid from request
        // Usefull for command operation with uuid as parameter
        if (($uuid = $request->attributes->get('uuid')) && Uuid::isValid($uuid)) {
            $context['uuid'] = Uuid::fromString($uuid);
        }

        return $context;
    }
}
