<?php

namespace SwaggerMiddlewareTest\Middleware;

use SwaggerMiddleware\Middleware\SwaggerUI;
use SwaggerMiddleware\Middleware\SwaggerUIFactory;
use PHPUnit\Framework\TestCase;

class SwaggerUIFactoryTest extends TestCase
{
    public function testCanCreate()
    {
        $container = $this->prophesize(\Psr\Container\ContainerInterface::class);
        $container->get('config')->willReturn(['swagger-middleware' => []])->shouldBeCalled();

        $factory = new SwaggerUIFactory();
        $this->assertInstanceOf(SwaggerUI::class, $factory->__invoke($container->reveal()));
    }
}
