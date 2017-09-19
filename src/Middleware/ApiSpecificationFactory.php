<?php

namespace SwaggerMiddleware\Middleware;

use Psr\Container\ContainerInterface;

class ApiSpecificationFactory
{
    public function __invoke(ContainerInterface $container)
    {
        return new ApiSpecification($container->get(\SwaggerMiddleware\Generator::class));
    }
}
