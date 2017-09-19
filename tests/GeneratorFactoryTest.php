<?php

namespace SwaggerMiddlewareTest;

use SwaggerMiddleware\Generator;
use SwaggerMiddleware\GeneratorFactory;
use PHPUnit\Framework\TestCase;

class GeneratorFactoryTest extends TestCase
{
    public function testCanCreate()
    {
        $container = $this->prophesize(\Psr\Container\ContainerInterface::class);
        $container->get('config')->willReturn([
            'swagger-middleware' => [
                'scan' => [
                    'paths' => ['api.php']
                ]
            ]
        ])->shouldBeCalled();

        $factory = new GeneratorFactory();
        $this->assertInstanceOf(Generator::class, $factory->__invoke($container->reveal()));
    }
}
