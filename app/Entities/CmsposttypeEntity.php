<?php

declare(strict_types=1);

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class CmsposttypeEntity extends Entity
{
    protected $casts = [
'id' => 'integer',
        'name' => 'string',
        'slug' => 'string',
        'schema' => 'json-array',
    ];

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
}
