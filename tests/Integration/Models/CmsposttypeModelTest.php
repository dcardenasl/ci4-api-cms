<?php

namespace Tests\Integration\Models;

use App\Models\CmsposttypeModel;
use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\DatabaseTestTrait;

/**
 * @internal
 */
final class CmsposttypeModelTest extends CIUnitTestCase
{
    use DatabaseTestTrait;

    protected $migrate = true;
    protected $namespace = 'App';

    private CmsposttypeModel $model;

    protected function setUp(): void
    {
        parent::setUp();
        $this->model = new CmsposttypeModel();
    }

    public function testInsertAndFindReturnsEntity(): void
    {
        $id = $this->model->insert([
            'name' => 'Article',
            'slug' => 'article',
            'schema' => json_encode([
                'fields' => [
                    ['name' => 'video_url', 'type' => 'url', 'required' => true],
                ],
            ]),
        ]);

        $this->assertIsInt($id);
        $found = $this->model->find($id);
        $this->assertNotNull($found);
        $this->assertSame('Article', (string) $found->name);
    }

    public function testSoftDeleteHidesRecordByDefault(): void
    {
        $id = $this->model->insert([
            'name' => 'To Delete',
            'slug' => 'to-delete',
            'schema' => json_encode(['fields' => []]),
        ]);

        $this->assertIsInt($id);
        $this->assertTrue($this->model->delete($id));
        $this->assertNull($this->model->find($id));
        $this->assertNotNull($this->model->withDeleted()->find($id));
    }

    public function testValidationRejectsMissingName(): void
    {
        $result = $this->model->insert([
            'slug' => 'missing-name',
            'schema' => json_encode(['fields' => []]),
        ]);

        $this->assertFalse($result);
        $this->assertArrayHasKey('name', $this->model->errors());
    }
}
