<?php

declare(strict_types=1);

namespace Acme\Infrastructure\Bridge\ApiPlatform\Swagger;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class AuthSwaggerDecorator implements NormalizerInterface
{
    private NormalizerInterface $decorated;

    public function __construct(NormalizerInterface $decorated)
    {
        $this->decorated = $decorated;
    }

    public function supportsNormalization($data, string $format = null): bool
    {
        return $this->decorated->supportsNormalization($data, $format);
    }

    /**
     * {@inheritdoc}
     *
     * @return array|string|int|float|bool|\ArrayObject<string, mixed>|null
     */
    public function normalize($object, string $format = null, array $context = [])
    {
        /** @var array $docs */
        $docs = $this->decorated->normalize($object, $format, $context);

        // Override Bearer definition according to https://swagger.io/docs/specification/authentication/bearer-authentication/
        // User will only have to put token value, without `Bearer` prefix
        $docs['components']['securitySchemes']['Bearer']['type'] = 'http';
        $docs['components']['securitySchemes']['Bearer']['scheme'] = 'bearer';
        $docs['components']['securitySchemes']['Bearer']['bearerFormat'] = 'JWT';

        $docs['components']['schemas']['Token'] = [
            'type' => 'object',
            'properties' => [
                'token' => [
                    'type' => 'string',
                    'readOnly' => true,
                ],
            ],
        ];

        $docs['components']['schemas']['AuthCredentials'] = [
            'type' => 'object',
            'properties' => [
                'username' => [
                    'type' => 'string',
                    'example' => 'user@example.com',
                ],
                'password' => [
                    'type' => 'string',
                    'example' => 'yourstrongpassword',
                ],
            ],
        ];

        $tokenDocumentation = [
            'paths' => [
                '/api/auth_check' => [
                    'post' => [
                        'tags' => ['Auth'],
                        'operationId' => 'postCredentialsItem',
                        'summary' => 'Get JWT token to login',
                        'requestBody' => [
                            'description' => 'Create new JWT Token',
                            'content' => [
                                'application/json' => [
                                    'schema' => [
                                        '$ref' => '#/components/schemas/AuthCredentials',
                                    ],
                                ],
                            ],
                        ],
                        'responses' => [
                            Response::HTTP_OK => [
                                'description' => 'Get JWT token',
                                'content' => [
                                    'application/json' => [
                                        'schema' => [
                                            '$ref' => '#/components/schemas/Token',
                                        ],
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ];

        // Ensure token documentation is on top of documentation
        return \array_merge_recursive($tokenDocumentation, $docs);
    }
}
