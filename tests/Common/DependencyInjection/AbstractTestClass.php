<?php
namespace Tests\Common\DependencyInjection;

use Matthias\SymfonyDependencyInjectionTest\PhpUnit\AbstractExtensionTestCase;
use Yoanm\SymfonyJsonRpcParamsSfConstraintsDoc\DependencyInjection\JsonRpcParamsSfConstraintsDocExtension;

abstract class AbstractTestClass extends AbstractExtensionTestCase
{
    // Public services
    const EXPECTED_SERVER_DOC_CREATED_LISTENER_SERVICE_ID = 'json_rpc_params_sf_constraints_doc.listener.jsonrpc_doc_server_created';
    const EXPECTED_METHOD_DOC_CREATED_LISTENER_SERVICE_ID = 'json_rpc_params_sf_constraints_doc.listener.jsonrpc_doc_method_created';

    /**
     * {@inheritdoc}
     */
    protected function getContainerExtensions()
    {
        return [
            new JsonRpcParamsSfConstraintsDocExtension()
        ];
    }

    protected function load(array $configurationValues = [])
    {
        parent::load($configurationValues);

        // And then compile container to have correct injection
        $this->compile();
    }

    protected function assertIsLoadable()
    {
        // Retrieving this service will imply to load all related dependencies
        // Any binding issues will be raised
        $this->assertNotNull($this->container->get(self::EXPECTED_SERVER_DOC_CREATED_LISTENER_SERVICE_ID));
        $this->assertNotNull($this->container->get(self::EXPECTED_METHOD_DOC_CREATED_LISTENER_SERVICE_ID));
    }
}
