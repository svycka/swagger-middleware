<?php

namespace SwaggerMiddlewareTest\Middleware;

use SwaggerMiddleware\Generator;
use SwaggerMiddleware\Middleware\ApiSpecification;
use PHPUnit\Framework\TestCase;
use Laminas\Diactoros\ServerRequest;

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
        $response = $this->middleware->handle(new ServerRequest());

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals($swagger, $response->getPayload());
    }
}
