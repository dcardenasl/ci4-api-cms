<?php

namespace Tests\Feature\Controllers\Cms;

use App\Models\CmsposttypeModel;
use App\Models\CmssectionModel;
use Tests\Support\ApiTestCase;
use Tests\Support\Traits\AuthTestTrait;

/**
 * @internal
 */
final class CmspostControllerTest extends ApiTestCase
{
    use AuthTestTrait;

    private int $sectionId;
    private int $postTypeId;

    protected function setUp(): void
    {
        parent::setUp();

        $sectionModel = model(CmssectionModel::class);
        $this->sectionId = $sectionModel->insert([
            'name' => 'Tech Blog',
            'slug' => 'tech-blog-123',
            'description' => 'A blog about tech',
            'status' => 'active'
        ]);

        $postTypeModel = model(CmsposttypeModel::class);
        $this->postTypeId = $postTypeModel->insert([
            'name' => 'Article',
            'slug' => 'article-123',
            'schema' => json_encode([
                'fields' => [
                    ['name' => 'video_url', 'type' => 'url', 'required' => true],
                    ['name' => 'gallery', 'type' => 'image_array', 'required' => false]
                ]
            ])
        ]);
    }

    public function testStoreValidatesCustomDataJsonSchema(): void
    {
        $payload = [
            'section_id' => $this->sectionId,
            'post_type_id' => $this->postTypeId,
            'title' => 'My New Smartphone',
            'slug' => 'my-new-smartphone',
            'content' => 'Review of the new phone',
            'custom_data' => [
                // missing video_url which is required by the schema
                'gallery' => ['img1.jpg']
            ],
            'status' => 'published',
            'published_at' => date('Y-m-d H:i:s')
        ];

        // Should return 422 Validation Error
        $this->actAs('admin');
        $response = $this->withBodyFormat('json')->post('/api/v1/cms/cmsposts', $payload);
        $response->assertStatus(422);

        $json = json_decode($response->getJSON(), true);
        $this->assertArrayHasKey('custom_data.video_url', $json['errors']);

        // Provide the correct payload
        $payload['custom_data']['video_url'] = 'https://youtube.com/watch?v=123';
        $this->resetRequest();
        $this->actAs('admin');
        $responseSuccess = $this->withBodyFormat('json')->post('/api/v1/cms/cmsposts', $payload);
        $responseSuccess->assertStatus(201);
    }
}
