<?php
namespace Tests\Functional\DependencyInjection;

use Tests\Common\DependencyInjection\AbstractTestClass;
use Yoanm\JsonRpcParamsSymfonyConstraintDoc\App\Helper\ConstraintPayloadDocHelper;
use Yoanm\JsonRpcParamsSymfonyConstraintDoc\App\Helper\DocTypeHelper;
use Yoanm\JsonRpcParamsSymfonyConstraintDoc\App\Helper\MinMaxHelper;
use Yoanm\JsonRpcParamsSymfonyConstraintDoc\App\Helper\StringDocHelper;
use Yoanm\JsonRpcParamsSymfonyConstraintDoc\App\Helper\TypeGuesser;
use Yoanm\JsonRpcParamsSymfonyConstraintDoc\Infra\Transformer\ConstraintToParamsDocTransformer;
use Yoanm\SymfonyJsonRpcParamsSfConstraintsDoc\Listener\MethodDocCreatedListener;
use Yoanm\SymfonyJsonRpcParamsSfConstraintsDoc\Listener\ServerDocCreatedListener;

/**
 * /!\ This test class does not cover JsonRpcHttpServerDocExtension, it covers yaml configuration files
 * => So no [at]covers tag ! (but @coversNothing is mandatory to avoid failure)
 * @coversNothing
 */
class ConfigFilesTest extends AbstractTestClass
{
    /**
     * @dataProvider provideSDKInfraServiceIdAndClass
     * @dataProvider provideSDKAppServiceIdAndClass
     * @dataProvider provideBundlePublicServiceIdAndClass
     *
     * @param string $serviceId
     * @param string $expectedClassName
     * @param bool   $public
     */
    public function testShouldHaveService($serviceId, $expectedClassName, $public)
    {
        $this->loadContainer();

        $this->assertContainerBuilderHasService($serviceId, $expectedClassName);
        if (true === $public) {
            // Check that service is accessible through the container
            $this->assertNotNull($this->container->get($serviceId));
        }

        $this->assertIsLoadable();
    }

    public function testServerDocCreatedListenerShouldHaveRightTags()
    {
        $this->loadContainer();

        // From yoanm/symfony-jsonrpc-http-server
        $this->assertContainerBuilderHasServiceDefinitionWithTag(
            self::EXPECTED_SERVER_DOC_CREATED_LISTENER_SERVICE_ID,
            'kernel.event_listener',
            [
                'event' => 'json_rpc_http_server_doc.server_doc_created',
                'method' => 'enhanceParamValidationErrorDoc',
            ]
        );
    }

    public function testMethodDocCreatedListenerShouldHaveRightTags()
    {
        $this->loadContainer();

        // From yoanm/symfony-jsonrpc-http-server
        $this->assertContainerBuilderHasServiceDefinitionWithTag(
            self::EXPECTED_METHOD_DOC_CREATED_LISTENER_SERVICE_ID,
            'kernel.event_listener',
            [
                'event' => 'json_rpc_http_server_doc.method_doc_created',
                'method' => 'enhanceMethodDoc',
            ]
        );
    }

    /**
     * @return array
     */
    public function provideSDKInfraServiceIdAndClass()
    {
        return [
            'SDK - Infra - ConstraintToParamsDocTransformer' => [
                'serviceId' => 'json_rpc_params_sf_constraints_doc_sdk.tranformer',
                'serviceClassName' => ConstraintToParamsDocTransformer::class,
                'public' => true,
            ],
        ];
    }

    /**
     * @return array
     */
    public function provideSDKAppServiceIdAndClass()
    {
        return [
            'SDK - APP - DocTypeHelper' => [
                'serviceId' => 'json_rpc_params_sf_constraints_doc_sdk.helper.type',
                'serviceClassName' => DocTypeHelper::class,
                'public' => false,
            ],
            'SDK - APP - TypeGuesser' => [
                'serviceId' => 'json_rpc_params_sf_constraints_doc_sdk.helper.type_guesser',
                'serviceClassName' => TypeGuesser::class,
                'public' => false,
            ],
            'SDK - APP - StringDocHelper' => [
                'serviceId' => 'json_rpc_params_sf_constraints_doc_sdk.helper.string',
                'serviceClassName' => StringDocHelper::class,
                'public' => false,
            ],
            'SDK - APP - MinMaxHelper' => [
                'serviceId' => 'json_rpc_params_sf_constraints_doc_sdk.helper.min_max',
                'serviceClassName' => MinMaxHelper::class,
                'public' => false,
            ],
            'SDK - APP - ConstraintPayloadDocHelper' => [
                'serviceId' => 'json_rpc_params_sf_constraints_doc_sdk.helper.constraint_doc_payload',
                'serviceClassName' => ConstraintPayloadDocHelper::class,
                'public' => false,
            ],
        ];
    }

    /**
     * @return array
     */
    public function provideBundlePublicServiceIdAndClass()
    {
        return [
            'Bundle - Public - ServerDocCreatedListener' => [
                'serviceId' => 'json_rpc_params_sf_constraints_doc.listener.jsonrpc_doc_server_created',
                'serviceClassName' => ServerDocCreatedListener::class,
                'public' => true,
            ],
            'Bundle - Public - MethodDocCreatedListener' => [
                'serviceId' => 'json_rpc_params_sf_constraints_doc.listener.jsonrpc_doc_method_created',
                'serviceClassName' => MethodDocCreatedListener::class,
                'public' => true,
            ],
        ];
    }
}
