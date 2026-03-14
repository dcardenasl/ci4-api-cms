<?php

declare(strict_types=1);

namespace App\Services\Cms;

use App\Interfaces\Cms\CmsposttypeServiceInterface;
use App\Interfaces\Core\RepositoryInterface;
use App\Interfaces\Mappers\ResponseMapperInterface;
use App\Services\Core\BaseCrudService;

class CmsposttypeService extends BaseCrudService implements CmsposttypeServiceInterface
{
    public function __construct(
        RepositoryInterface $cmsposttypeRepository,
        ResponseMapperInterface $responseMapper
    ) {
        parent::__construct($cmsposttypeRepository, $responseMapper);
    }

    /**
     * Domain Hooks
     *
     * Implement beforeStore, afterStore, beforeUpdate, etc.,
     * to add specific business logic while keeping the service layer clean.
     */

    protected function beforeStore(array $data, ?\App\DTO\SecurityContext $context): array
    {
        if (array_key_exists('schema', $data)) {
            $schema = $this->normalizeSchema($data['schema']);
            $data['schema'] = json_encode($schema);
        }

        return $data;
    }

    protected function beforeUpdate(int $id, array $data, ?\App\DTO\SecurityContext $context): array
    {
        if (array_key_exists('schema', $data)) {
            $schema = $this->normalizeSchema($data['schema']);
            $data['schema'] = json_encode($schema);
        }

        return $data;
    }

    private function normalizeSchema(mixed $schema): array
    {
        if (is_string($schema)) {
            $decoded = json_decode($schema, true);
            if (json_last_error() !== JSON_ERROR_NONE || !is_array($decoded)) {
                throw new \App\Exceptions\ValidationException(
                    lang('Api.validationFailed'),
                    ['schema' => lang('Cmsposttypes.invalid_json')]
                );
            }
            return $decoded;
        }

        if (!is_array($schema)) {
            throw new \App\Exceptions\ValidationException(
                lang('Api.validationFailed'),
                ['schema' => lang('Cmsposttypes.invalid_json')]
            );
        }

        return $schema;
    }
}
