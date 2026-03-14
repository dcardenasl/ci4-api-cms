<?php

declare(strict_types=1);

namespace App\Controllers\Api\V1\Cms;

use App\Controllers\ApiController;
use App\DTO\Request\Cms\CmsposttypeCreateRequestDTO;
use App\DTO\Request\Cms\CmsposttypeIndexRequestDTO;
use App\DTO\Request\Cms\CmsposttypeUpdateRequestDTO;
use App\Traits\Controllers\HasCrudActions;
use Config\Services;

class CmsposttypeController extends ApiController
{
    use HasCrudActions;

    protected function resolveDefaultService(): object
    {
        return Services::cmsposttypeService();
    }

    protected string $indexDto = CmsposttypeIndexRequestDTO::class;
    protected string $createDto = CmsposttypeCreateRequestDTO::class;
    protected string $updateDto = CmsposttypeUpdateRequestDTO::class;

    protected array $statusCodes = [
        'store' => 201,
    ];
}
