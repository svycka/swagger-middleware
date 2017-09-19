<?php

namespace SwaggerMiddleware\Middleware;

use Interop\Http\ServerMiddleware\DelegateInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface as ServerMiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\HtmlResponse;

class SwaggerUI implements ServerMiddlewareInterface
{
    /**
     * @var array
     */
    private $config;

    public function __construct(array $config)
    {
        $this->config = $config;
    }

    public function process(ServerRequestInterface $request, DelegateInterface $delegate)
    {
        $template = file_get_contents(dirname(__DIR__).'/templates/documentation.phtml');

        $template = str_replace([
            '{__TITLE__}',
            '{__ASSETS_PATH__}',
            '{__API_SPEC_URL__}',
        ], [
            $this->config['title'],
            $this->config['routes']['assets'],
            $this->config['routes']['specification'],
        ], $template);

        return new HtmlResponse($template);
    }
}
