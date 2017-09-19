<?php

namespace SwaggerMiddlewareTest\Middleware;

use SwaggerMiddleware\Generator;
use SwaggerMiddleware\Middleware\ApiSpecificationFactory;
use SwaggerMiddleware\Middleware\ApiSpecification;
use PHPUnit\Framework\TestCase;

class ApiSpecificationFactoryTest extends TestCase
{
    public function testCanCreate()
    {
        $container = $this->prophesize(\Psr\Container\ContainerInterface::class);
        $container->get(Generator::class)->willReturn(new Generator(['scan' => ['paths' => ['api.php']]]))
            ->shouldBeCalled();

        $factory = new ApiSpecificationFactory();
        $this->assertInstanceOf(ApiSpecification::class, $factory->__invoke($container->reveal()));
    }
}
