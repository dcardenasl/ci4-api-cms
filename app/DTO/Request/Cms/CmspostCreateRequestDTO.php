<?php

declare(strict_types=1);

namespace App\DTO\Request\Cms;

use App\DTO\Request\BaseRequestDTO;
use OpenApi\Attributes as OA;

#[OA\Schema(schema: 'CmspostCreateRequest')]
readonly class CmspostCreateRequestDTO extends BaseRequestDTO
{
    public int $section_id;
    public int $post_type_id;
    public string $title;
    public string $slug;
    public string $content;
    public array $custom_data;
    public string $status;
    public string $published_at;

    public function rules(): array
    {
        return [
            'section_id' => 'required|is_natural_no_zero',
            'post_type_id' => 'required|is_natural_no_zero',
            'title' => 'required|string|max_length[255]',
            'slug' => 'required|string|max_length[255]',
            'content' => 'required|string',
            'custom_data' => 'required',
            'status' => 'required|string|max_length[255]',
            'published_at' => 'required|valid_date',
        ];
    }

    protected function map(array $data): void
    {
        $this->section_id = (int) ($data['section_id'] ?? 0);
        $this->post_type_id = (int) ($data['post_type_id'] ?? 0);
        $this->title = (string) ($data['title'] ?? '');
        $this->slug = (string) ($data['slug'] ?? '');
        $this->content = (string) ($data['content'] ?? '');
        $this->custom_data = $this->normalizeJsonArray($data['custom_data'] ?? []);
        $this->status = (string) ($data['status'] ?? '');
        $this->published_at = (string) ($data['published_at'] ?? '');
    }

    public function toArray(): array
    {
        return [
            'section_id' => $this->section_id,
            'post_type_id' => $this->post_type_id,
            'title' => $this->title,
            'slug' => $this->slug,
            'content' => $this->content,
            'custom_data' => $this->custom_data,
            'status' => $this->status,
            'published_at' => $this->published_at,
        ];
    }

    private function normalizeJsonArray(mixed $value): array
    {
        if (is_string($value)) {
            $decoded = json_decode($value, true);
            if (json_last_error() !== JSON_ERROR_NONE || !is_array($decoded)) {
                throw new \App\Exceptions\ValidationException(
                    lang('Api.validationFailed'),
                    ['custom_data' => lang('Cmsposts.invalid_json')]
                );
            }
            return $decoded;
        }

        if (!is_array($value)) {
            throw new \App\Exceptions\ValidationException(
                lang('Api.validationFailed'),
                ['custom_data' => lang('Cmsposts.invalid_json')]
            );
        }

        return $value;
    }
}
