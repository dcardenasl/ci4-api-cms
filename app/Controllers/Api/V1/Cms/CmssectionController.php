<?php

declare(strict_types=1);

namespace App\Controllers\Api\V1\Cms;

use App\Controllers\ApiController;
use App\DTO\Request\Cms\CmssectionCreateRequestDTO;
use App\DTO\Request\Cms\CmssectionIndexRequestDTO;
use App\DTO\Request\Cms\CmssectionUpdateRequestDTO;
use App\Traits\Controllers\HasCrudActions;
use Config\Services;

class CmssectionController extends ApiController
{
    use HasCrudActions;

    protected function resolveDefaultService(): object
    {
        return Services::cmssectionService();
    }

    protected string $indexDto = CmssectionIndexRequestDTO::class;
    protected string $createDto = CmssectionCreateRequestDTO::class;
    protected string $updateDto = CmssectionUpdateRequestDTO::class;

    protected array $statusCodes = [
        'store' => 201,
    ];
}
