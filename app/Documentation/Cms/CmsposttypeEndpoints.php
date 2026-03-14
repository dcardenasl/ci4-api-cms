<?php

declare(strict_types=1);

namespace App\Documentation\Cms;

use OpenApi\Attributes as OA;

/**
 * OpenAPI definitions for Cmsposttype endpoints.
 *
 * @OA\Tag(name="Cms", description="Cms management")
 */
class CmsposttypeEndpoints
{
    #[OA\Get(
        path: '/api/v1/cms/cmsposttypes',
        tags: ['Cms'],
        summary: 'List Cmsposttypes',
        responses: [
            new OA\Response(
                response: 200,
                description: 'List retrieved successfully',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'status', type: 'string', example: 'success'),
                        new OA\Property(
                            property: 'data',
                            type: 'array',
                            items: new OA\Items(ref: '#/components/schemas/CmsposttypeResponse')
                        ),
                    ],
                    type: 'object'
                )
            ),
        ]
    )]
    public function index()
    {
    }

    #[OA\Post(
        path: '/api/v1/cms/cmsposttypes',
        tags: ['Cms'],
        summary: 'Create new Cmsposttype',
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(ref: '#/components/schemas/CmsposttypeCreateRequest')
        ),
        responses: [
            new OA\Response(response: 201, description: 'Created successfully'),
            new OA\Response(response: 422, description: 'Validation error')
        ]
    )]
    public function store()
    {
    }

    #[OA\Get(
        path: '/api/v1/cms/cmsposttypes/{id}',
        tags: ['Cms'],
        summary: 'Get Cmsposttype by ID',
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))
        ],
        responses: [
            new OA\Response(response: 200, description: 'Found'),
            new OA\Response(response: 404, description: 'Not found')
        ]
    )]
    public function show()
    {
    }
}
