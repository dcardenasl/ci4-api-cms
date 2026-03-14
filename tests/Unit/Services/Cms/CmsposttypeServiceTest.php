<?php

namespace Tests\Unit\Services\Cms;

use App\Services\Cms\CmsposttypeService;
use CodeIgniter\Test\CIUnitTestCase;
use ReflectionMethod;

/**
 * @internal
 */
final class CmsposttypeServiceTest extends CIUnitTestCase
{
    public function testIndexContractReturnsDataTransferObjectInterface(): void
    {
        $method = new ReflectionMethod(CmsposttypeService::class, 'index');
        $returnType = $method->getReturnType();
        $this->assertNotNull($returnType);
        $this->assertSame(\App\Interfaces\DataTransferObjectInterface::class, $returnType?->getName());
    }

    public function testStoreAndUpdateSignaturesUseDtoAndSecurityContext(): void
    {
        $store = new ReflectionMethod(CmsposttypeService::class, 'store');
        $update = new ReflectionMethod(CmsposttypeService::class, 'update');

        $storeParams = $store->getParameters();
        $updateParams = $update->getParameters();
        $storeContextType = (string) $storeParams[1]->getType();
        $updateContextType = (string) $updateParams[2]->getType();

        $this->assertSame(\App\Interfaces\DataTransferObjectInterface::class, (string) $storeParams[0]->getType());
        $this->assertSame(\App\DTO\SecurityContext::class, ltrim($storeContextType, '?'));
        $this->assertSame(\App\Interfaces\DataTransferObjectInterface::class, (string) $updateParams[1]->getType());
        $this->assertSame(\App\DTO\SecurityContext::class, ltrim($updateContextType, '?'));
    }
}
