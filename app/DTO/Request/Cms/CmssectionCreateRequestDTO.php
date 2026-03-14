<?php

declare(strict_types=1);

namespace App\DTO\Request\Cms;

use App\DTO\Request\BaseRequestDTO;
use OpenApi\Attributes as OA;

#[OA\Schema(schema: 'CmssectionCreateRequest')]
readonly class CmssectionCreateRequestDTO extends BaseRequestDTO
{
    public string $name;
    public string $slug;
    public string $description;
    public string $status;

    public function rules(): array
    {
        return [
            'name' => 'required|string|max_length[255]',
            'slug' => 'required|string|max_length[255]',
            'description' => 'required|string',
            'status' => 'required|string|max_length[255]',
        ];
    }

    protected function map(array $data): void
    {
        $this->name = (string) ($data['name'] ?? '');
        $this->slug = (string) ($data['slug'] ?? '');
        $this->description = (string) ($data['description'] ?? '');
        $this->status = (string) ($data['status'] ?? '');
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'slug' => $this->slug,
            'description' => $this->description,
            'status' => $this->status,
        ];
    }
}
