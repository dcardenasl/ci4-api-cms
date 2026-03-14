<?php

declare(strict_types=1);

namespace App\Services\Cms;

use App\Interfaces\Cms\CmspostServiceInterface;
use App\Interfaces\Core\RepositoryInterface;
use App\Interfaces\Mappers\ResponseMapperInterface;
use App\Services\Core\BaseCrudService;

class CmspostService extends BaseCrudService implements CmspostServiceInterface
{
    public function __construct(
        RepositoryInterface $cmspostRepository,
        ResponseMapperInterface $responseMapper
    ) {
        parent::__construct($cmspostRepository, $responseMapper);
    }

    protected function beforeStore(array $data, ?\App\DTO\SecurityContext $context): array
    {
        $customData = $this->normalizeCustomData($data['custom_data'] ?? []);
        $postTypeId = (int) ($data['post_type_id'] ?? 0);

        $this->validateCustomDataSchema($postTypeId, $customData);
        $data['custom_data'] = json_encode($customData);

        return $data;
    }

    protected function beforeUpdate(int $id, array $data, ?\App\DTO\SecurityContext $context): array
    {
        $shouldValidate = array_key_exists('post_type_id', $data) || array_key_exists('custom_data', $data);
        if ($shouldValidate) {
            $postTypeId = $data['post_type_id'] ?? null;
            $customData = $data['custom_data'] ?? null;

            if ($postTypeId === null || $customData === null) {
                $entity = $this->repository->find($id);
                if ($entity !== null) {
                    $entityData = method_exists($entity, 'toArray') ? $entity->toArray() : (array) $entity;
                    $postTypeId ??= $entityData['post_type_id'] ?? null;
                    $customData ??= $entityData['custom_data'] ?? [];
                }
            }

            $customData = $this->normalizeCustomData($customData ?? []);
            $this->validateCustomDataSchema((int) ($postTypeId ?? 0), $customData);
            $data['custom_data'] = json_encode($customData);
        }

        return $data;
    }

    private function normalizeCustomData(mixed $customData): array
    {
        if (is_string($customData)) {
            $decoded = json_decode($customData, true);
            if (json_last_error() !== JSON_ERROR_NONE || !is_array($decoded)) {
                throw new \App\Exceptions\ValidationException(
                    lang('Api.validationFailed'),
                    ['custom_data' => lang('Cmsposts.invalid_json')]
                );
            }
            return $decoded;
        }

        if (!is_array($customData)) {
            throw new \App\Exceptions\ValidationException(
                lang('Api.validationFailed'),
                ['custom_data' => lang('Cmsposts.invalid_json')]
            );
        }

        return $customData;
    }

    private function validateCustomDataSchema(int $postTypeId, array $customData): void
    {
        if ($postTypeId <= 0) {
            throw new \App\Exceptions\ValidationException(
                lang('Api.validationFailed'),
                ['post_type_id' => lang('Cmsposts.invalid_post_type')]
            );
        }

        $postTypeService = service('cmsposttypeService');
        try {
            $postType = $postTypeService->show($postTypeId);
        } catch (\App\Exceptions\NotFoundException $e) {
            throw new \App\Exceptions\ValidationException(lang('Api.validationFailed'), ['post_type_id' => lang('Cmsposts.invalid_post_type')]);
        }

        $postTypeArray = $postType->toArray();
        $schemaStr = $postTypeArray['schema'] ?? '{}';
        $schema = is_string($schemaStr) ? json_decode($schemaStr, true) : $schemaStr;

        if (!is_array($schema) || empty($schema['fields'])) {
            return;
        }

        $errors = [];
        foreach ($schema['fields'] as $field) {
            $fieldName = $field['name'] ?? null;
            $isRequired = $field['required'] ?? false;

            if (!$fieldName) {
                continue;
            }

            if ($isRequired && (!isset($customData[$fieldName]) || $customData[$fieldName] === '')) {
                $errors['custom_data.' . $fieldName] = lang('Cmsposts.field_required', [$fieldName]);
            }
        }

        if (!empty($errors)) {
            throw new \App\Exceptions\ValidationException(lang('Api.validationFailed'), $errors);
        }
    }
}
