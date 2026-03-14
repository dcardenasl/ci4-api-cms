<?php

declare(strict_types=1);

namespace App\Services\Cms;

use App\Interfaces\Cms\CmssectionServiceInterface;
use App\Interfaces\Core\RepositoryInterface;
use App\Interfaces\Mappers\ResponseMapperInterface;
use App\Services\Core\BaseCrudService;

class CmssectionService extends BaseCrudService implements CmssectionServiceInterface
{
    public function __construct(
        RepositoryInterface $cmssectionRepository,
        ResponseMapperInterface $responseMapper
    ) {
        parent::__construct($cmssectionRepository, $responseMapper);
    }

    /**
     * Domain Hooks
     *
     * Implement beforeStore, afterStore, beforeUpdate, etc.,
     * to add specific business logic while keeping the service layer clean.
     */
}
