<?php

declare(strict_types=1);

namespace App\DTO\Request\Cms;

use App\DTO\Request\BaseRequestDTO;
use OpenApi\Attributes as OA;

#[OA\Schema(schema: 'CmsposttypeCreateRequest')]
readonly class CmsposttypeCreateRequestDTO extends BaseRequestDTO
{
    public string $name;
    public string $slug;
    public array $schema;

    public function rules(): array
    {
        return [
            'name' => 'required|string|max_length[255]',
            'slug' => 'required|string|max_length[255]',
            'schema' => 'required',
        ];
    }

    protected function map(array $data): void
    {
        $this->name = (string) ($data['name'] ?? '');
        $this->slug = (string) ($data['slug'] ?? '');
        $this->schema = $this->normalizeJsonArray($data['schema'] ?? []);
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'slug' => $this->slug,
            'schema' => $this->schema,
        ];
    }

    private function normalizeJsonArray(mixed $value): array
    {
        if (is_string($value)) {
            $decoded = json_decode($value, true);
            if (json_last_error() !== JSON_ERROR_NONE || !is_array($decoded)) {
                throw new \App\Exceptions\ValidationException(
                    lang('Api.validationFailed'),
                    ['schema' => lang('Cmsposttypes.invalid_json')]
                );
            }
            return $decoded;
        }

        if (!is_array($value)) {
            throw new \App\Exceptions\ValidationException(
                lang('Api.validationFailed'),
                ['schema' => lang('Cmsposttypes.invalid_json')]
            );
        }

        return $value;
    }
}
