<?php

namespace Kispiox\Middleware;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

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
    public function __construct(MiddlewareInterface $final, array $middleware = [])
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
        return $this;
    }

    /**
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     */
    public function dispatch(ServerRequestInterface $request)
    {
        $first = $this->get(0);
        return $first($request, null);
    }

    /**
     * @param int $pos Get middleware at the nth position
     * @return callable
     */
    public function get($pos)
    {
        $middleware = null;
        $next = function () {};

        if (isset($this->middleware[$pos])) {
            $middleware = $this->middleware[$pos];
        } elseif ($pos == count($this->middleware) + 1) {
            $middleware = $this->final;
        } else {
            return $next;
        }

        if (!is_callable($middleware)) {
            throw new UnexpectedValueException(
                'middleware item at position '.$pos.' is not callable'
            );
        }

        $next = function (ServerRequestInterface $request) use ($middleware, $pos) {
            return $middleware->process($request, $this->get($pos+1));
        };

        return $next;
    }
}
