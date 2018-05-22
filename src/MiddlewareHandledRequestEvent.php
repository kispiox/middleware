<?php

/**
 * kispiox/middleware - A middleware library for Kispiox
 * github.com/kispiox/middleware
 *
 * MiddlewareHandledRequestEvent.php
 * @copyright Copyright (c) 2018 Matt Ferris
 * @author Matt Ferris <matt@bueller.ca>
 *
 * Licensed under BSD 2-clause license
 * github.com/kispiox/middleware/blob/master/LICENSE
 */

namespace Kispiox\Middleware;

use MattFerris\Events\EventInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;

class MiddlewareHandledRequestEvent implements EventInterface
{
    /**
     * @var MiddlewareInterface    
     */
    protected $middleware;

    /**
     * @var ServerRequestInterface
     */
    protected $request;

    /**
     * @var ResponseInterface
     */
    protected $response;

    /**
     * @param MiddlewareInterface $middleware
     * @param ServerRequestInterface $request
     */
    public function __construct(
        MiddlewareInterface $middleware,
        ServerRequestInterface $request,
        ResponseInterface $response
        )
    {
        $this->middleware = $middleware;
        $this->request = $request;
    }

    /**
     * @return MiddlewareInterface
     */
    public function getMiddleware()
    {
        return $this->middleware;
    }

    /**
     * @return ServerRequestInterface
     */
    public function getRequest()
    {
        return $this->request;
    }
}

