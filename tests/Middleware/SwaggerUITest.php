<?php

namespace SwaggerMiddlewareTest\Middleware;

use SwaggerMiddleware\Middleware\SwaggerUI;
use Interop\Http\ServerMiddleware\DelegateInterface;
use PHPUnit\Framework\TestCase;
use Zend\Diactoros\ServerRequest;

class SwaggerUITest extends TestCase
{
    public function testCanRenderSwaggerUIPage()
    {
        $config = [
            'title' => 'Test API',
            'routes' => [
                'assets' => '/assets/path/',
                'specification' => '/docs/spec.json',
            ]
        ];
        $swaggerUI = new SwaggerUI($config);
        $response = $swaggerUI->process(
            new ServerRequest(),
            $this->prophesize(DelegateInterface::class)->reveal()
        );

        $this->assertEquals(200, $response->getStatusCode());
        $html = $response->getBody()->getContents();

        $this->assertContains(sprintf('<title>%s</title>', $config['title']), $html);
        $this->assertContains($config['routes']['assets'], $html);
        $this->assertContains('url: "/docs/spec.json",', $html);
        $this->assertNotContains('{__TITLE__}', $html);
        $this->assertNotContains('{__ASSETS_PATH__}', $html);
        $this->assertNotContains('{__API_SPEC_URL__}', $html);
    }
}
