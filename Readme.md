Middleware for Kispiox
======================

```php
use Kispiox\Middleware\MiddlewareDispatcher;
use MattFerris\HttpRouting\Dispatcher;
use Zend\Diactoros\ServerRequest;

$final = new Dispatcher();

$dispatcher = new MiddlewareDispatcher($final, [
    $middlewareA,
    $middlewareB,
    ...
]);

$dispatcher->add($middlewareC);

$response = $dispatcher->dispatch(ServerRequest::fromGlobals());
```
