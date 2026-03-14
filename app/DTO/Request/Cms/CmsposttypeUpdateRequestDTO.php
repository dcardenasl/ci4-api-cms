<?php

declare(strict_types=1);

namespace App\DTO\Request\Cms;

use App\DTO\Request\BaseRequestDTO;

readonly class CmsposttypeUpdateRequestDTO extends BaseRequestDTO
{
    public ?string $name;
    public ?string $slug;
    public ?array $schema;

    public function rules(): array
    {
        return [
            'name' => 'permit_empty|string|max_length[255]',
            'slug' => 'permit_empty|string|max_length[255]',
            'schema' => 'permit_empty',
        ];
    }

    protected function map(array $data): void
    {
        $this->name = isset($data['name']) ? (string) $data['name'] : null;
        $this->slug = isset($data['slug']) ? (string) $data['slug'] : null;
        $this->schema = $this->mapSchema($data);
    }

    public function toArray(): array
    {
        return array_filter([
            'name' => $this->name,
            'slug' => $this->slug,
            'schema' => $this->schema,
        ], fn ($v) => $v !== null);
    }

    private function mapSchema(array $data): ?array
    {
        if (!array_key_exists('schema', $data)) {
            return null;
        }

        $value = $data['schema'];
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
