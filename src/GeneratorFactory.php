<?php

namespace SwaggerMiddleware;

use Psr\Container\ContainerInterface;

class GeneratorFactory
{
    /**
     * @param ContainerInterface $container
     *
     * @return Generator
     */
    public function __invoke(ContainerInterface $container)
    {
        $config = $container->get('config')['swagger-middleware'];

        return new Generator($config);
    }
}
