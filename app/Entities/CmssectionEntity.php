<?php

declare(strict_types=1);

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class CmssectionEntity extends Entity
{
    protected $casts = [
'id' => 'integer',
        'name' => 'string',
        'slug' => 'string',
        'description' => 'string',
        'status' => 'string',
    ];

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
}
