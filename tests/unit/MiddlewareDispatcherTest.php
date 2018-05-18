<?php

use Kispiox\Middleware\MiddlewareDispatcher;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;

class MiddlewareDispatcherTest extends TestCase
{
    public function testAdd()
    {
        $final = $this->createMock(MiddlewareInterface::class);
        $mw = $this->createMock(MiddlewareInterface::class);

        $dispatcher = new MiddlewareDispatcher($mw);
        $return = $dispatcher->add($mw);

        $this->assertSame($dispatcher, $return);
    }

    /**
     * @depends testAdd
     */
    public function testDispatch()
    {
        $req = $this->createMock(ServerRequestInterface::class);
        $res = $this->createMock(ResponseInterface::class);

        $mw = $this->createMock(MiddlewareInterface::class);
        $mw->expects($this->once())
            ->method('process')
            ->with($req)
            ->willReturn($res);

        $response = (new MiddlewareDispatcher($mw))->dispatch($req);
        $this->assertEquals($res, $response);
    }
}

