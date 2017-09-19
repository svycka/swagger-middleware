<?php

namespace SwaggerMiddleware\Middleware;

use Psr\Container\ContainerInterface;

class SwaggerUIFactory
{
    public function __invoke(ContainerInterface $container)
    {
        return new SwaggerUI(
            $container->get('config')['swagger-middleware']
        );
    }
}
