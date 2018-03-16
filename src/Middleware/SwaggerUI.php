<?php

namespace SwaggerMiddleware\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\HtmlResponse;

class SwaggerUI implements RequestHandlerInterface
{
    /**
     * @var array
     */
    private $config;

    public function __construct(array $config)
    {
        $this->config = $config;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
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
