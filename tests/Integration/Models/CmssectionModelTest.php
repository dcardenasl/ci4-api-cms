<?php

namespace Tests\Integration\Models;

use App\Models\CmssectionModel;
use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\DatabaseTestTrait;

/**
 * @internal
 */
final class CmssectionModelTest extends CIUnitTestCase
{
    use DatabaseTestTrait;

    protected $migrate = true;
    protected $namespace = 'App';

    private CmssectionModel $model;

    protected function setUp(): void
    {
        parent::setUp();
        $this->model = new CmssectionModel();
    }

    public function testInsertAndFindReturnsEntity(): void
    {
        $id = $this->model->insert([
            'name' => 'Tech Blog',
            'slug' => 'tech-blog',
            'description' => 'A blog about tech',
            'status' => 'active',
        ]);

        $this->assertIsInt($id);
        $found = $this->model->find($id);
        $this->assertNotNull($found);
        $this->assertSame('Tech Blog', (string) $found->name);
    }

    public function testSoftDeleteHidesRecordByDefault(): void
    {
        $id = $this->model->insert([
            'name' => 'To Delete',
            'slug' => 'to-delete',
            'description' => 'Temp',
            'status' => 'active',
        ]);

        $this->assertIsInt($id);
        $this->assertTrue($this->model->delete($id));
        $this->assertNull($this->model->find($id));
        $this->assertNotNull($this->model->withDeleted()->find($id));
    }

    public function testValidationRejectsMissingName(): void
    {
        $this->expectException(\CodeIgniter\Database\Exceptions\DataException::class);
        $this->model->insert([
            'slug' => 'missing-name',
            'description' => 'Missing name',
            'status' => 'active',
        ]);
    }
}
