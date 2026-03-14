<?php

namespace Tests\Feature\Controllers\Cms;

use App\Models\CmsposttypeModel;
use Tests\Support\ApiTestCase;
use Tests\Support\Traits\AuthTestTrait;

/**
 * @internal
 */
final class CmsposttypeControllerTest extends ApiTestCase
{
    use AuthTestTrait;

    private CmsposttypeModel $model;

    protected function setUp(): void
    {
        parent::setUp();
        $this->model = new CmsposttypeModel();
    }

    public function testEndpointsRequireAuthentication(): void
    {
        $result = $this->get('/api/v1/cms/cmsposttypes');
        $result->assertStatus(401);
    }

    public function testEndpointsRequireAdminRole(): void
    {
        $this->actAs('user');

        $list = $this->get('/api/v1/cms/cmsposttypes');
        $list->assertStatus(403);
    }

    public function testAdminCrudFlowWorks(): void
    {
        $this->actAs('admin');

        $create = $this->withBodyFormat('json')->post('/api/v1/cms/cmsposttypes', [
            'name' => 'Article',
            'slug' => 'article',
            'schema' => [
                'fields' => [
                    ['name' => 'video_url', 'type' => 'url', 'required' => true],
                ],
            ],
        ]);
        $create->assertStatus(201);
        $createJson = $this->getResponseJson($create);
        $id = (int) ($createJson['data']['id'] ?? 0);
        $this->assertGreaterThan(0, $id);

        $list = $this->get('/api/v1/cms/cmsposttypes');
        $list->assertStatus(200);

        $show = $this->get("/api/v1/cms/cmsposttypes/{$id}");
        $show->assertStatus(200);

        $update = $this->withBodyFormat('json')->put("/api/v1/cms/cmsposttypes/{$id}", [
            'name' => 'Article Updated',
        ]);
        $update->assertStatus(200);

        $delete = $this->delete("/api/v1/cms/cmsposttypes/{$id}");
        $delete->assertStatus(200);

        $this->assertNull($this->model->find($id));
        $this->assertNotNull($this->model->withDeleted()->find($id));
    }
}
