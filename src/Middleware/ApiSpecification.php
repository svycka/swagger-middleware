<?php

namespace SwaggerMiddleware\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\RequestHandlerInterface;
use SwaggerMiddleware\Generator;
use Psr\Http\Message\ServerRequestInterface;
use Laminas\Diactoros\Response\JsonResponse;

final class ApiSpecification implements RequestHandlerInterface
{
    /**
     * @var Generator
     */
    private $generator;

    /**
     * SpecApi constructor.
     *
     * @param Generator $generator
     */
    public function __construct(Generator $generator)
    {
        $this->generator = $generator;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        return new JsonResponse($this->generator->generate());
    }
}
