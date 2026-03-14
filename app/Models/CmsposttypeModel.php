<?php

declare(strict_types=1);

namespace App\Models;

use App\Entities\CmsposttypeEntity;
use App\Traits\Filterable;
use App\Traits\Searchable;

class CmsposttypeModel extends BaseAuditableModel
{
    use Filterable;
    use Searchable;

    protected $table = 'cmsposttypes';
    protected $primaryKey = 'id';
    protected $returnType = CmsposttypeEntity::class;
    protected $useSoftDeletes = true;
    protected $useTimestamps = true;

    protected $allowedFields = ['name', 'slug', 'schema'];

    /** @var array<int, string> */
    protected array $searchableFields = ['name', 'slug'];
    /** @var array<int, string> */
    protected array $filterableFields = ['id', 'name', 'slug', 'created_at'];
    /** @var array<int, string> */
    protected array $sortableFields = ['id', 'name', 'created_at'];

    protected $validationRules = [
        'name' => 'required|string|max_length[255]',
        'slug' => 'required|string|max_length[255]',
        'schema' => 'required',
    ];
}
