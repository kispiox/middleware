<?php

use Kispiox\Middleware\Handlers\CallableHandler;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class CallableHandlerTest extends TestCase
{
    public function testHandle()
    {
        $res = $this->createMock(ResponseInterface::class);
        $handler = new CallableHandler(function () use ($res) { return $res; });
        $response = $handler->handle($this->createMock(ServerRequestInterface::class));
        $this->assertSame($res, $response);
    }

    public function testProcess()
    {
        $res = $this->createMock(ResponseInterface::class);
        $middleware = new CallableHandler(function () use ($res) { return $res; });
        $response = $middleware->process(
            $this->createMock(ServerRequestInterface::class),
            $this->createMock(RequestHandlerInterface::class)
        );
        $this->assertSame($res, $response);
    }

    public function testInvoke()
    {
        $res = $this->createMock(ResponseInterface::class);
        $closure = new CallableHandler(function () use ($res) { return $res; });
        $response = $closure($this->createMock(ServerRequestInterface::class));
        $this->assertSame($res, $response);
    }
}

