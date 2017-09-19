<?php

namespace SwaggerMiddleware\Middleware;

use SwaggerMiddleware\Generator;
use Interop\Http\ServerMiddleware\DelegateInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface as ServerMiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\JsonResponse;

final class ApiSpecification implements ServerMiddlewareInterface
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

    public function process(ServerRequestInterface $request, DelegateInterface $delegate)
    {
        return new JsonResponse($this->generator->generate());
    }
}
