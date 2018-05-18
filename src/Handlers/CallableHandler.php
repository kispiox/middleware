<?php

/**
 * kispiox/middleware - A middleware library for Kispiox
 * github.com/kispiox/middleware
 *
 * Handlers/CallableHandler.php
 * @copyright Copyright (c) 2018 Matt Ferris
 * @author Matt Ferris <matt@bueller.ca>
 *
 * Licensed under BSD 2-clause license
 * github.com/kispiox/middleware/blob/master/LICENSE
 */

namespace Kispiox\Middleware\Handlers;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class CallableHandler implements MiddlewareInterface, RequestHandlerInterface
{
    /**
     * @var callable
     */
    protected $callable;

    /**
     * @param callable $callable The callable used to handle the request
     */
    public function __construct(callable $callable)
    {
        $this->callable = $callable;
    }

    /**
     * {@inheritDoc}
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        return call_user_func($this->callable, $request);
    } 

    /**
     * {@inheritDoc}
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        return call_user_func($this->callable, $request, $handler);
    }

    public function __invoke(ServerRequestInterface $request): ResponseInterface
    {
        return call_user_func_array($this->callable, func_get_args());
    } 
}

