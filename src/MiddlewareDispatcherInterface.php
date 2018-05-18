<?php

namespace Kispiox\Middleware;

use Psr\Http\Message\ServerRequestInterface
use Psr\Http\Server\MiddlewareInterface;

interface MiddlewareDispatcherInterface
{
    /**
     * @param MiddlewareInterface $middleware
     * @return self
     */
    public function add(MiddlewareInterface $middleware);

    /**
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     */
    public function dispatch(ServerRequestInterface $request);
}
