<?php

use Kispiox\Middleware\MiddlewareDispatcher;
use Kispiox\Middleware\MiddlewareInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;

class MiddlewareDispatcherTest extends PHPUnit_Framework_TestCase
{
    public function testConstruct()
    {
        $dispatcher = new MiddlewareDispatcher(function () {});
    }

    /**
     * @depends testConstruct
     */
    public function testAdd()
    {
        $mw = $this->getMock(MiddlewareInterface::class);

        $dispatcher = new MiddlewareDispatcher(function () {});
        $return = $dispatcher->add($mw);

        $this->assertInstanceOf(MiddlewareDispatcher::class, $return);
    }

    /**
     * @depends testConstruct
     */
    public function testDispatch()
    {
        $req = $this->getMock(ServerRequestInterface::class);

        $res = $this->getMock(ResponseInterface::class);

        $mw = $this->getMock(MiddlewareInterface::class);
        $mw
            ->expects($this->once())
            ->method('process')
            ->with($req)
            ->willReturn($res);

        $dispatcher = new MiddlewareDispatcher($mw);

        $response = $dispatcher->dispatch($req);

        $this->assertEquals($response, $res);
    }
}

