<?php

declare(strict_types=1);

namespace Config;

trait CmsDomainServices
{
    public static function cmssectionResponseMapper(bool $getShared = true): \App\Interfaces\Mappers\ResponseMapperInterface
    {
        if ($getShared) {
            return static::getSharedInstance('cmssectionResponseMapper');
        }

        return new \App\Services\Core\Mappers\DtoResponseMapper(
            \App\DTO\Response\Cms\CmssectionResponseDTO::class
        );
    }

    public static function cmssectionService(bool $getShared = true): \App\Interfaces\Cms\CmssectionServiceInterface
    {
        if ($getShared) {
            return static::getSharedInstance('cmssectionService');
        }

        return new \App\Services\Cms\CmssectionService(
            new \App\Repositories\GenericRepository(model(\App\Models\CmssectionModel::class)),
            static::cmssectionResponseMapper()
        );
    }

    public static function cmsposttypeResponseMapper(bool $getShared = true): \App\Interfaces\Mappers\ResponseMapperInterface
    {
        if ($getShared) {
            return static::getSharedInstance('cmsposttypeResponseMapper');
        }

        return new \App\Services\Core\Mappers\DtoResponseMapper(
            \App\DTO\Response\Cms\CmsposttypeResponseDTO::class
        );
    }

    public static function cmsposttypeService(bool $getShared = true): \App\Interfaces\Cms\CmsposttypeServiceInterface
    {
        if ($getShared) {
            return static::getSharedInstance('cmsposttypeService');
        }

        return new \App\Services\Cms\CmsposttypeService(
            new \App\Repositories\GenericRepository(model(\App\Models\CmsposttypeModel::class)),
            static::cmsposttypeResponseMapper()
        );
    }

    public static function cmspostResponseMapper(bool $getShared = true): \App\Interfaces\Mappers\ResponseMapperInterface
    {
        if ($getShared) {
            return static::getSharedInstance('cmspostResponseMapper');
        }

        return new \App\Services\Core\Mappers\DtoResponseMapper(
            \App\DTO\Response\Cms\CmspostResponseDTO::class
        );
    }

    public static function cmspostService(bool $getShared = true): \App\Interfaces\Cms\CmspostServiceInterface
    {
        if ($getShared) {
            return static::getSharedInstance('cmspostService');
        }

        return new \App\Services\Cms\CmspostService(
            new \App\Repositories\GenericRepository(model(\App\Models\CmspostModel::class)),
            static::cmspostResponseMapper()
        );
    }
}
