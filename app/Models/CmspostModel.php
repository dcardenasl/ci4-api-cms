<?php

declare(strict_types=1);

namespace App\Models;

use App\Entities\CmspostEntity;
use App\Traits\Filterable;
use App\Traits\Searchable;

class CmspostModel extends BaseAuditableModel
{
    use Filterable;
    use Searchable;

    protected $table = 'cmsposts';
    protected $primaryKey = 'id';
    protected $returnType = CmspostEntity::class;
    protected $useSoftDeletes = true;
    protected $useTimestamps = true;

    protected $allowedFields = ['section_id', 'post_type_id', 'title', 'slug', 'content', 'custom_data', 'status', 'published_at'];

    /** @var array<int, string> */
    protected array $searchableFields = ['title', 'slug', 'content'];
    /** @var array<int, string> */
    protected array $filterableFields = ['id', 'section_id', 'post_type_id', 'status', 'created_at'];
    /** @var array<int, string> */
    protected array $sortableFields = ['id', 'created_at', 'published_at'];

    protected $validationRules = [
        'section_id' => 'required|is_natural_no_zero',
        'post_type_id' => 'required|is_natural_no_zero',
        'title' => 'required|string|max_length[255]',
        'slug' => 'required|string|max_length[255]',
        'content' => 'required|string',
        'custom_data' => 'required',
        'status' => 'required|string|max_length[255]',
        'published_at' => 'required|valid_date',
    ];
}
