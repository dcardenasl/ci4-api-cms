<?php

namespace Tests\Integration\Models;

use App\Models\CmspostModel;
use App\Models\CmsposttypeModel;
use App\Models\CmssectionModel;
use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\DatabaseTestTrait;

/**
 * @internal
 */
final class CmspostModelTest extends CIUnitTestCase
{
    use DatabaseTestTrait;

    protected $migrate = true;
    protected $namespace = 'App';

    private CmspostModel $model;
    private CmssectionModel $sectionModel;
    private CmsposttypeModel $postTypeModel;

    protected function setUp(): void
    {
        parent::setUp();
        $this->model = new CmspostModel();
        $this->sectionModel = new CmssectionModel();
        $this->postTypeModel = new CmsposttypeModel();
    }

    public function testInsertAndFindReturnsEntity(): void
    {
        $sectionId = $this->sectionModel->insert([
            'name' => 'Tech Blog',
            'slug' => 'tech-blog',
            'description' => 'A blog about tech',
            'status' => 'active',
        ]);

        $postTypeId = $this->postTypeModel->insert([
            'name' => 'Article',
            'slug' => 'article',
            'schema' => json_encode(['fields' => []]),
        ]);

        $id = $this->model->insert([
            'section_id' => $sectionId,
            'post_type_id' => $postTypeId,
            'title' => 'Post A',
            'slug' => 'post-a',
            'content' => 'Content',
            'custom_data' => json_encode(['fields' => []]),
            'status' => 'published',
            'published_at' => date('Y-m-d H:i:s'),
        ]);

        $this->assertIsInt($id);
        $found = $this->model->find($id);
        $this->assertNotNull($found);
        $this->assertSame('Post A', (string) $found->title);
    }

    public function testSoftDeleteHidesRecordByDefault(): void
    {
        $sectionId = $this->sectionModel->insert([
            'name' => 'Delete Section',
            'slug' => 'delete-section',
            'description' => 'Temp',
            'status' => 'active',
        ]);

        $postTypeId = $this->postTypeModel->insert([
            'name' => 'Delete Type',
            'slug' => 'delete-type',
            'schema' => json_encode(['fields' => []]),
        ]);

        $id = $this->model->insert([
            'section_id' => $sectionId,
            'post_type_id' => $postTypeId,
            'title' => 'To Delete',
            'slug' => 'to-delete',
            'content' => 'Content',
            'custom_data' => json_encode(['fields' => []]),
            'status' => 'published',
            'published_at' => date('Y-m-d H:i:s'),
        ]);

        $this->assertIsInt($id);
        $this->assertTrue($this->model->delete($id));
        $this->assertNull($this->model->find($id));
        $this->assertNotNull($this->model->withDeleted()->find($id));
    }

    public function testValidationRejectsMissingTitle(): void
    {
        $sectionId = $this->sectionModel->insert([
            'name' => 'Validation Section',
            'slug' => 'validation-section',
            'description' => 'Temp',
            'status' => 'active',
        ]);

        $postTypeId = $this->postTypeModel->insert([
            'name' => 'Validation Type',
            'slug' => 'validation-type',
            'schema' => json_encode(['fields' => []]),
        ]);

        $this->expectException(\CodeIgniter\Database\Exceptions\DataException::class);
        $this->model->insert([
            'section_id' => $sectionId,
            'post_type_id' => $postTypeId,
            'slug' => 'missing-title',
            'content' => 'Content',
            'custom_data' => json_encode(['fields' => []]),
            'status' => 'published',
            'published_at' => date('Y-m-d H:i:s'),
        ]);
    }
}
