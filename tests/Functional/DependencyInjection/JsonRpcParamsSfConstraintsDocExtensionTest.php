<?php
namespace Tests\Functional\DependencyInjection;

use Tests\Common\DependencyInjection\AbstractTestClass;
use Yoanm\SymfonyJsonRpcParamsSfConstraintsDoc\DependencyInjection\JsonRpcParamsSfConstraintsDocExtension;

/**
 * @covers \Yoanm\SymfonyJsonRpcParamsSfConstraintsDoc\DependencyInjection\JsonRpcParamsSfConstraintsDocExtension
 */
class JsonRpcParamsSfConstraintsDocExtensionTest extends AbstractTestClass
{
    public function testShouldBeLoadable()
    {
        $this->load();

        $this->assertIsLoadable();
    }

    public function testShouldReturnAnXsdValidationBasePath()
    {
        $this->assertNotNull((new JsonRpcParamsSfConstraintsDocExtension())->getXsdValidationBasePath());
    }
}
