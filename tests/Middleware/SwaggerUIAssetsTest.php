<?php

namespace SwaggerMiddlewareTest\Middleware;

use SwaggerMiddleware\Middleware\SwaggerUIAssets;
use Interop\Http\ServerMiddleware\DelegateInterface;
use PHPUnit\Framework\TestCase;
use Zend\Diactoros\Response;
use Zend\Diactoros\ServerRequest;

class SwaggerUIAssetsTest extends TestCase
{
    public function testCanReturnAssetsWithCorrectContentType()
    {
        $swaggerUIAssets = new SwaggerUIAssets();
        $request = (new ServerRequest())->withAttribute('asset', 'favicon-16x16.png');
        $response = $swaggerUIAssets->process(
            $request,
            $this->prophesize(DelegateInterface::class)->reveal()
        );

        $this->assertEquals('image/png', $response->getHeaderLine('Content-Type'));

        $request = (new ServerRequest())->withAttribute('asset', 'oauth2-redirect.html');
        $response = $swaggerUIAssets->process(
            $request,
            $this->prophesize(DelegateInterface::class)->reveal()
        );

        $this->assertEquals('text/html', $response->getHeaderLine('Content-Type'));

        $request = (new ServerRequest())->withAttribute('asset', 'swagger-ui-bundle.js');
        $response = $swaggerUIAssets->process(
            $request,
            $this->prophesize(DelegateInterface::class)->reveal()
        );

        $this->assertEquals('application/javascript', $response->getHeaderLine('Content-Type'));

        $request = (new ServerRequest())->withAttribute('asset', 'swagger-ui.css');
        $response = $swaggerUIAssets->process(
            $request,
            $this->prophesize(DelegateInterface::class)->reveal()
        );

        $this->assertEquals('text/css', $response->getHeaderLine('Content-Type'));
    }

    public function testCanReturnAllAssets()
    {
        $swaggerUIAssets = new SwaggerUIAssets();

        foreach (SwaggerUIAssets::ALLOWED_FILES as $asset) {
            $request = (new ServerRequest())->withAttribute('asset', $asset);
            $response = $swaggerUIAssets->process(
                $request,
                $this->prophesize(DelegateInterface::class)->reveal()
            );

            $this->assertEquals(200, $response->getStatusCode());
        }
    }

    public function testDelegateToNextMiddlewareWhenAssetNotFound()
    {
        $swaggerUIAssets = new SwaggerUIAssets();
        $delegate = $this->prophesize(DelegateInterface::class);
        $request = (new ServerRequest())->withAttribute('asset', 'fake-image.png');

        $delegate->process($request)->willReturn($notFoundResponse = new Response())->shouldBeCalled();
        $response = $swaggerUIAssets->process($request, $delegate->reveal());

        $this->assertEquals($notFoundResponse, $response);
    }
}