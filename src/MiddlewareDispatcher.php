<?php

/**
 * kispiox/middleware - A middleware library for Kispiox
 * github.com/kispiox/middleware
 *
 * MiddlewareDispatcher.php
 * @copyright Copyright (c) 2018 Matt Ferris
 * @author Matt Ferris <matt@bueller.ca>
 *
 * Licensed under BSD 2-clause license
 * github.com/kispiox/middleware/blob/master/LICENSE
 */

namespace Kispiox\Middleware;

use Kispiox\Middleware\Handlers\CallableHandler;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use UnexpectedValueException;

class MiddlewareDispatcher implements MiddlewareDispatcherInterface
{
    /**
     * @var MiddlewareInterface[]
     */
    protected $middleware;

    /**
     * @var MiddlewareInterface
     */
    protected $final;

    /**
     * @param MiddlewareInterface $final
     * @param MiddlewareInterface[] $middleware
     */
    public function __construct(MiddlewareInterface $final = null, array $middleware = [])
    {
        $this->final = $final;
        $this->middleware = $middleware;
    }

    /**
     * @param MiddlewareInterface $middleware
     * @return self
     */
    public function add(MiddlewareInterface $middleware)
    {
        $this->middleware[] = $middleware;
        DomainEvents::dispatch(new MiddlewareAddedEvent($middleware));
        return $this;
    }

    /**
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     */
    public function dispatch(ServerRequestInterface $request)
    {
        $first = $this->get(0);
        return $first($request);
    }

    /**
     * @param int $pos Get middleware at the nth position
     * @return callable
     */
    public function get($pos)
    {
        $mc = count($this->middleware);
        $middleware = null;
        $next = function () {};

        if (isset($this->middleware[$pos])) {
            $middleware = $this->middleware[$pos];
        } elseif (isset($this->final) && ($mc == 0 || $pos > $mc)) {
            $middleware = $this->final;
        } else {
            return $next;
        }

        if (is_callable($middleware)) {
            $middleware = new CallableHandler($middleware);
        }

        if (!($middleware instanceof MiddlewareInterface)) {
            throw new UnexpectedValueException(
                'middleware must implement '.MiddlewareInterface::class
            );
        }

        $next = new CallableHandler(function (ServerRequestInterface $request) use ($middleware, $pos) {
            $return = $middleware->process($request, $this->get($pos+1));
            DomainEvents::dispatch(new MiddlewareHandledRequestEvent($middleware, $request, $return));
            return $return;
        });

        return $next;
    }
}
