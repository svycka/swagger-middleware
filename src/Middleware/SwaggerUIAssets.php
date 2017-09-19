<?php

namespace SwaggerMiddleware\Middleware;

use Interop\Http\ServerMiddleware\DelegateInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface as ServerMiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response;

class SwaggerUIAssets implements ServerMiddlewareInterface
{
    const ALLOWED_FILES = [
        'favicon-16x16.png',
        'favicon-32x32.png',
        'oauth2-redirect.html',
        'swagger-ui-bundle.js',
        'swagger-ui-bundle.js.map',
        'swagger-ui-standalone-preset.js',
        'swagger-ui-standalone-preset.js.map',
        'swagger-ui.css',
        'swagger-ui.css.map',
        'swagger-ui.js',
        'swagger-ui.js.map',
    ];

    public function process(ServerRequestInterface $request, DelegateInterface $delegate)
    {
        $asset = $request->getAttribute('asset');

        if (!in_array($asset, self::ALLOWED_FILES, true)) {
            return $delegate->process($request);
        }

        $file = $this->getAssetsPath() . $asset;

        return new Response(
            fopen($file, 'rb'),
            200,
            ['Content-Type' => $this->getMimeType($file)]
        );
    }

    private function getMimeType(string $file) : string
    {
        $extension = pathinfo($file)['extension'];
        switch ($extension) {
            case 'css':
                return 'text/css';
            case 'png':
                return 'image/png';
            case 'html':
                return 'text/html';
            default:
                return 'application/javascript';
        }
    }

    private function getAssetsPath()
    {
        if (file_exists(dirname(__DIR__, 4) . '/swagger-api/swagger-ui/dist/')) {
            return dirname(__DIR__, 4) . '/swagger-api/swagger-ui/dist/';
        }
        if (file_exists(dirname(__DIR__, 2) . '/vendor/swagger-api/swagger-ui/dist/')) {
            return dirname(__DIR__, 2) . '/vendor/swagger-api/swagger-ui/dist/';
        }
        throw new \RuntimeException('Unable to find SwaggerUI assets path.');
    }
}
