<?php

namespace SwaggerMiddleware;

use Zend\ServiceManager\Factory\InvokableFactory;

/**
 * The configuration provider for the SwaggerMiddleware module
 *
 * @see https://docs.zendframework.com/zend-component-installer/
 */
class ConfigProvider
{
    /**
     * Returns the configuration array
     *
     * To add a bit of a structure, each section is defined in a separate
     * method which returns an array with its configuration.
     *
     * @return array
     */
    public function __invoke()
    {
        return [
            'dependencies' => $this->getDependencies(),
            'swagger-middleware' => $this->getModuleConfig(),
        ];
    }

    /**
     * Returns the container dependencies
     *
     * @return array
     */
    public function getDependencies() : array
    {
        return [
            'factories'  => [
                Generator::class => GeneratorFactory::class,
                Middleware\ApiSpecification::class => Middleware\ApiSpecificationFactory::class,
                Middleware\SwaggerUIAssets::class => InvokableFactory::class,
                Middleware\SwaggerUI::class => Middleware\SwaggerUIFactory::class,
            ],
        ];
    }

    public function getModuleConfig() : array
    {
        return [
            'title' => 'API Spec',
            'scan' => [
                'paths' => [],
                'options' => [],
            ],
            'routes' => [
                'specification' => '/docs/spec.json',
                'assets' => '/docs/assets/',
            ],
        ];
    }
}
