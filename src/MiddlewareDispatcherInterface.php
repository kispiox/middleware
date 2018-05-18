<?php

/**
 * kispiox/middleware - A middleware library for Kispiox
 * github.com/kispiox/middleware
 * 
 * MiddlewareDispatcherInterface.php
 * @copyright Copyright (c) 2018 Matt Ferris
 * @author Matt Ferris <matt@bueller.ca>
 *
 * Licensed under BSD 2-clause license
 * github.com/kispiox/middleware/blob/master/LICENSE
 */

namespace Kispiox\Middleware;

use Psr\Http\Message\ServerRequestInterface;
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
