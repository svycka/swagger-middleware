<?php

namespace SwaggerMiddlewareTest\Middleware;

use SwaggerMiddleware\Generator;
use SwaggerMiddleware\Middleware\ApiSpecification;
use Interop\Http\ServerMiddleware\DelegateInterface;
use PHPUnit\Framework\TestCase;
use Zend\Diactoros\ServerRequest;

class ApiSpecificationTest extends TestCase
{
    /** @var ApiSpecification */
    private $middleware;
    private $generator;

    public function setUp()
    {
        $this->generator = $this->prophesize(Generator::class);
        $this->middleware = new ApiSpecification($this->generator->reveal());
    }

    public function testWillGenerateAndReturnSpecification()
    {
        $this->generator->generate()->willReturn($swagger = new \Swagger\Annotations\Swagger([]))->shouldBeCalled();
        $response = $this->middleware->process(
            new ServerRequest(),
            $this->prophesize(DelegateInterface::class)->reveal()
        );

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals($swagger, $response->getPayload());
    }
}
