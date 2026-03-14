<?php

declare(strict_types=1);

namespace App\DTO\Request\Cms;

use App\DTO\Request\BaseRequestDTO;

readonly class CmspostUpdateRequestDTO extends BaseRequestDTO
{
    public ?int $section_id;
    public ?int $post_type_id;
    public ?string $title;
    public ?string $slug;
    public ?string $content;
    public ?array $custom_data;
    public ?string $status;
    public ?string $published_at;

    public function rules(): array
    {
        return [
            'section_id' => 'permit_empty|is_natural_no_zero',
            'post_type_id' => 'permit_empty|is_natural_no_zero',
            'title' => 'permit_empty|string|max_length[255]',
            'slug' => 'permit_empty|string|max_length[255]',
            'content' => 'permit_empty|string',
            'custom_data' => 'permit_empty',
            'status' => 'permit_empty|string|max_length[255]',
            'published_at' => 'permit_empty|valid_date',
        ];
    }

    protected function map(array $data): void
    {
        $this->section_id = isset($data['section_id']) ? (int) $data['section_id'] : null;
        $this->post_type_id = isset($data['post_type_id']) ? (int) $data['post_type_id'] : null;
        $this->title = isset($data['title']) ? (string) $data['title'] : null;
        $this->slug = isset($data['slug']) ? (string) $data['slug'] : null;
        $this->content = isset($data['content']) ? (string) $data['content'] : null;
        $this->custom_data = $this->mapCustomData($data);
        $this->status = isset($data['status']) ? (string) $data['status'] : null;
        $this->published_at = isset($data['published_at']) ? (string) $data['published_at'] : null;
    }

    public function toArray(): array
    {
        return array_filter([
            'section_id' => $this->section_id,
            'post_type_id' => $this->post_type_id,
            'title' => $this->title,
            'slug' => $this->slug,
            'content' => $this->content,
            'custom_data' => $this->custom_data,
            'status' => $this->status,
            'published_at' => $this->published_at,
        ], fn ($v) => $v !== null);
    }

    private function mapCustomData(array $data): ?array
    {
        if (!array_key_exists('custom_data', $data)) {
            return null;
        }

        $value = $data['custom_data'];
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
