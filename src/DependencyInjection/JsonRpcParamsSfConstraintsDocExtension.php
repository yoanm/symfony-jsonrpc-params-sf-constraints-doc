<?php
namespace Yoanm\SymfonyJsonRpcParamsSfConstraintsDoc\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

/**
 * Class JsonRpcParamsSfConstraintsDocExtension
 */
class JsonRpcParamsSfConstraintsDocExtension implements ExtensionInterface
{
    // Extension identifier (used in configuration for instance)
    const EXTENSION_IDENTIFIER = 'json_rpc_params_sf_constraints_doc';

    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new YamlFileLoader(
            $container,
            new FileLocator(__DIR__.'/../Resources/config')
        );
        $loader->load('services.sdk.app.yaml');
        $loader->load('services.sdk.infra.yaml');
        $loader->load('services.public.yaml');
    }

    /**
     * {@inheritdoc}
     */
    public function getNamespace()
    {
        return 'http://example.org/schema/dic/'.$this->getAlias();
    }

    /**
     * {@inheritdoc}
     */
    public function getXsdValidationBasePath()
    {
        return '';
    }

    /**
     * {@inheritdoc}
     */
    public function getAlias()
    {
        return self::EXTENSION_IDENTIFIER;
    }
}
