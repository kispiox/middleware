<?php

/**
 * kispiox/middleware - A middleware library for Kispiox
 * github.com/kispiox/middleware
 *
 * MiddlewareAddedEvent.php
 * @copyright Copyright (c) 2018 Matt Ferris
 * @author Matt Ferris <matt@bueller.ca>
 *
 * Licensed under BSD 2-clause license
 * github.com/kispiox/middleware/blob/master/LICENSE
 */

namespace Kispiox\Middleware;

use MattFerris\Events\EventInterface;
use Psr\Http\Server\MiddlewareInterface;

class MiddlewareAddedEvent implements EventInterface
{
    /**
     * @var MiddlewareInterface    
     */
    protected $middleware;

    /**
     * @param MiddlewareInterface $middleware
     */
    public function __construct(MiddlewareInterface $middleware)
    {
        $this->middleware = $middleware;
    }

    /**
     * @return MiddlewareInterface
     */
    public function getMiddleware()
    {
        return $this->middleware;
    }
}

