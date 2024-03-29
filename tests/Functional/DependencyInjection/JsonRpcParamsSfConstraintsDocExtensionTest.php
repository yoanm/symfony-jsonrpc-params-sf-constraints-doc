<?php
namespace Tests\Functional\DependencyInjection;

use Prophecy\PhpUnit\ProphecyTrait;
use Tests\Common\DependencyInjection\AbstractTestClass;
use Yoanm\SymfonyJsonRpcParamsSfConstraintsDoc\DependencyInjection\JsonRpcParamsSfConstraintsDocExtension;

/**
 * @covers \Yoanm\SymfonyJsonRpcParamsSfConstraintsDoc\DependencyInjection\JsonRpcParamsSfConstraintsDocExtension
 */
class JsonRpcParamsSfConstraintsDocExtensionTest extends AbstractTestClass
{
    use ProphecyTrait;

    public function testShouldBeLoadable()
    {
        $this->loadContainer();

        $this->assertIsLoadable();
    }

    public function testShouldReturnAnXsdValidationBasePath()
    {
        $this->assertNotNull((new JsonRpcParamsSfConstraintsDocExtension())->getXsdValidationBasePath());
    }
}
