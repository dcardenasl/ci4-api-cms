<?php

declare(strict_types=1);

namespace App\Controllers\Api\V1\Cms;

use App\Controllers\ApiController;
use App\DTO\Request\Cms\CmspostCreateRequestDTO;
use App\DTO\Request\Cms\CmspostIndexRequestDTO;
use App\DTO\Request\Cms\CmspostUpdateRequestDTO;
use App\Traits\Controllers\HasCrudActions;
use Config\Services;

class CmspostController extends ApiController
{
    use HasCrudActions;

    protected function resolveDefaultService(): object
    {
        return Services::cmspostService();
    }

    protected string $indexDto = CmspostIndexRequestDTO::class;
    protected string $createDto = CmspostCreateRequestDTO::class;
    protected string $updateDto = CmspostUpdateRequestDTO::class;

    protected array $statusCodes = [
        'store' => 201,
    ];
}
