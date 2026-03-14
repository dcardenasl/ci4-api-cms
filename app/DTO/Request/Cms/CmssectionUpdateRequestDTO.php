<?php

declare(strict_types=1);

namespace App\DTO\Request\Cms;

use App\DTO\Request\BaseRequestDTO;

readonly class CmssectionUpdateRequestDTO extends BaseRequestDTO
{
    public ?string $name;
    public ?string $slug;
    public ?string $description;
    public ?string $status;

    public function rules(): array
    {
        return [
            'name' => 'permit_empty|string|max_length[255]',
            'slug' => 'permit_empty|string|max_length[255]',
            'description' => 'permit_empty|string',
            'status' => 'permit_empty|string|max_length[255]',
        ];
    }

    protected function map(array $data): void
    {
        $this->name = isset($data['name']) ? (string) $data['name'] : null;
        $this->slug = isset($data['slug']) ? (string) $data['slug'] : null;
        $this->description = isset($data['description']) ? (string) $data['description'] : null;
        $this->status = isset($data['status']) ? (string) $data['status'] : null;
    }

    public function toArray(): array
    {
        return array_filter([
            'name' => $this->name,
            'slug' => $this->slug,
            'description' => $this->description,
            'status' => $this->status,
        ], fn ($v) => $v !== null);
    }
}
