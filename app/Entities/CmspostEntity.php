<?php

declare(strict_types=1);

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class CmspostEntity extends Entity
{
    protected $casts = [
'id' => 'integer',
        'section_id' => 'integer',
        'post_type_id' => 'integer',
        'title' => 'string',
        'slug' => 'string',
        'content' => 'string',
        'custom_data' => 'json-array',
        'status' => 'string',
        'published_at' => 'datetime',
    ];

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
}
