<?php

declare(strict_types=1);

namespace App\Models;

use App\Entities\CmssectionEntity;
use App\Traits\Filterable;
use App\Traits\Searchable;

class CmssectionModel extends BaseAuditableModel
{
    use Filterable;
    use Searchable;

    protected $table = 'cmssections';
    protected $primaryKey = 'id';
    protected $returnType = CmssectionEntity::class;
    protected $useSoftDeletes = true;
    protected $useTimestamps = true;

    protected $allowedFields = ['name', 'slug', 'description', 'status'];

    /** @var array<int, string> */
    protected array $searchableFields = ['name', 'slug', 'description'];
    /** @var array<int, string> */
    protected array $filterableFields = ['id', 'name', 'slug', 'status', 'created_at'];
    /** @var array<int, string> */
    protected array $sortableFields = ['id', 'name', 'created_at'];

    protected $validationRules = [
        'name' => 'required|string|max_length[255]',
        'slug' => 'required|string|max_length[255]',
        'description' => 'required|string',
        'status' => 'required|string|max_length[255]',
    ];
}
