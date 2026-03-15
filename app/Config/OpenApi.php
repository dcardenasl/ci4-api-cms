<?php

namespace App\Config;

use OpenApi\Attributes as OA;

#[OA\OpenApi(
    openapi: '3.0.0',
)]
#[OA\Info(
    version: '1.0.0',
    title: 'ci4-api-cms API',
    description: 'CodeIgniter 4 API CMS template for the ci4-api-cms project',
)]
#[OA\Server(
    url: 'http://localhost:8080',
    description: 'Local development server'
)]
#[OA\SecurityScheme(
    securityScheme: 'bearerAuth',
    type: 'http',
    scheme: 'bearer',
    bearerFormat: 'JWT',
    description: 'Enter your JWT token in the format: Bearer {token}'
)]
#[OA\Tag(
    name: 'Authentication',
    description: 'User authentication endpoints'
)]
#[OA\Tag(
    name: 'Users',
    description: 'User management endpoints'
)]
#[OA\Tag(
    name: 'Files',
    description: 'File management endpoints'
)]
#[OA\Tag(
    name: 'Metrics',
    description: 'Operational metrics endpoints'
)]
#[OA\Tag(
    name: 'Audit',
    description: 'Audit log endpoints'
)]
#[OA\Tag(
    name: 'Health',
    description: 'Health and readiness endpoints'
)]
class OpenApi
{
    // This class only holds OpenAPI annotations
}
