# Symfony JSON-RPC params documentation

[![License](https://img.shields.io/github/license/yoanm/symfony-jsonrpc-params-sf-constraints-doc.svg)](https://github.com/yoanm/symfony-jsonrpc-params-sf-constraints-doc)
[![Code size](https://img.shields.io/github/languages/code-size/yoanm/symfony-jsonrpc-params-sf-constraints-doc.svg)](https://github.com/yoanm/symfony-jsonrpc-params-sf-constraints-doc)
[![Dependabot Status](https://api.dependabot.com/badges/status?host=github\&repo=yoanm/symfony-jsonrpc-params-sf-constraints-doc)](https://dependabot.com)

[![Scrutinizer Build Status](https://img.shields.io/scrutinizer/build/g/yoanm/symfony-jsonrpc-params-sf-constraints-doc.svg?label=Scrutinizer\&logo=scrutinizer)](https://scrutinizer-ci.com/g/yoanm/symfony-jsonrpc-params-sf-constraints-doc/build-status/master)
[![Scrutinizer Code Quality](https://img.shields.io/scrutinizer/g/yoanm/symfony-jsonrpc-params-sf-constraints-doc/master.svg?logo=scrutinizer)](https://scrutinizer-ci.com/g/yoanm/symfony-jsonrpc-params-sf-constraints-doc/?branch=master)
[![Codacy Badge](https://app.codacy.com/project/badge/Grade/8f39424add044b43a70bdb238e2f48db)](https://www.codacy.com/gh/yoanm/symfony-jsonrpc-params-sf-constraints-doc/dashboard?utm_source=github.com\&utm_medium=referral\&utm_content=yoanm/symfony-jsonrpc-params-sf-constraints-doc\&utm_campaign=Badge_Grade)

[![CI](https://github.com/yoanm/symfony-jsonrpc-params-sf-constraints-doc/actions/workflows/CI.yml/badge.svg?branch=master)](https://github.com/yoanm/symfony-jsonrpc-params-sf-constraints-doc/actions/workflows/CI.yml)
[![codecov](https://codecov.io/gh/yoanm/symfony-jsonrpc-params-sf-constraints-doc/branch/master/graph/badge.svg?token=NHdwEBUFK5)](https://codecov.io/gh/yoanm/symfony-jsonrpc-params-sf-constraints-doc)
[![Symfony Versions](https://img.shields.io/badge/Symfony-v4.4%20%2F%20v5.4%2F%20v6.x-8892BF.svg?logo=github)](https://symfony.com/)

[![Latest Stable Version](https://img.shields.io/packagist/v/yoanm/symfony-jsonrpc-params-sf-constraints-doc.svg)](https://packagist.org/packages/yoanm/symfony-jsonrpc-params-sf-constraints-doc)
[![Packagist PHP version](https://img.shields.io/packagist/php-v/yoanm/symfony-jsonrpc-params-sf-constraints-doc.svg)](https://packagist.org/packages/yoanm/symfony-jsonrpc-params-sf-constraints-doc)

Symfony bundle for easy Symfony constraints to JSON-RPC documentation transformation

Symfony bundle for [yoanm/jsonrpc-params-symfony-constraint-doc-sdk](https://github.com/yoanm/php-jsonrpc-params-symfony-constraint-doc-sdk)

## Versions

*   Symfony v3/4 - PHP >=7.1 : `^v0.X`
*   Symfony v4/5 - PHP >=7.2 : `^v1.0`
*   Symfony v4.4/5.5/6.x - PHP ^8.0 : `^v1.1`

## How to use

Once configured, your project will automatically create documentation for JSON-RPC params

See below how to configure it.

## Configuration

[Behat demo app configuration folders](./features/demo_app) can be used as examples.

*   Add the bundles in your config/bundles.php file:
    ```php
    // config/bundles.php
    return [
        ...
        Symfony\Bundle\FrameworkBundle\FrameworkBundle::class => ['all' => true],
        Yoanm\SymfonyJsonRpcHttpServer\JsonRpcHttpServerBundle::class => ['all' => true],
        Yoanm\SymfonyJsonRpcHttpServerDoc\JsonRpcHttpServerDocBundle::class => ['all' => true],
        Yoanm\SymfonyJsonRpcParamsSfConstraintsDoc\JsonRpcParamsSfConstraintsDocBundle::class => ['all' => true],
        ...
    ];
    ```

*   Configure `yoanm/symfony-jsonrpc-http-server` as described on [yoanm/symfony-jsonrpc-http-server](https://github.com/yoanm/symfony-jsonrpc-http-server) documentation.

*   Configure `yoanm/symfony-jsonrpc-http-server-doc` as described on [yoanm/symfony-jsonrpc-http-server-doc](https://github.com/yoanm/symfony-jsonrpc-http-server-doc) documentation.

*   Query your project at documentation endpoint and you should see JSON-RPC params documentation for each methods

 

## Contributing

See [contributing note](./CONTRIBUTING.md)
