<?php

declare(strict_types=1);

namespace App\DTO\Response\Cms;

use App\Interfaces\DataTransferObjectInterface;
use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'CmspostResponse',
    title: 'Cmspost Response',
    required: ["id"]
)]
readonly class CmspostResponseDTO implements DataTransferObjectInterface
{
    public function __construct(
        #[OA\Property(description: 'Unique identifier', example: 1)]
        public int $id,
        #[OA\Property(description: 'section_id', type: 'integer')]
        public int $section_id,
        #[OA\Property(description: 'post_type_id', type: 'integer')]
        public int $post_type_id,
        #[OA\Property(description: 'title', type: 'string')]
        public string $title,
        #[OA\Property(description: 'slug', type: 'string')]
        public string $slug,
        #[OA\Property(description: 'content', type: 'string')]
        public string $content,
        #[OA\Property(description: 'custom_data', type: 'object')]
        public array $custom_data,
        #[OA\Property(description: 'status', type: 'string')]
        public string $status,
        #[OA\Property(description: 'published_at', type: 'string', format: 'date-time')]
        public string $published_at,
        #[OA\Property(property: 'created_at', description: 'Creation timestamp', example: '2026-02-26 12:00:00', nullable: true)]
        public ?string $createdAt = null
    ) {
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'section_id' => $this->section_id,
            'post_type_id' => $this->post_type_id,
            'title' => $this->title,
            'slug' => $this->slug,
            'content' => $this->content,
            'custom_data' => $this->custom_data,
            'status' => $this->status,
            'published_at' => $this->published_at,
            'created_at' => $this->createdAt,
        ];
    }
}
