<?php

/**
 * kispiox/middleware - A middleware library for Kispiox
 * github.com/kispiox/middleware
 *
 * Component/ServicesProvider.php
 * @copyright Copyright (c) 2018 Matt Ferris
 * @author Matt Ferris <matt@bueller.ca>
 *
 * Licensed under BSD 2-clause license
 * github.com/kispiox/middleware/blob/master/LICENSE
 */

namespace Kispiox\Middleware\Component;

use Kispiox\Middleware\MiddlewareDispatcher;

class ServicesProvider extends Component
{
    public function provides($consumer)
    {
        $dispatcher = $consumer->injectConstructor(MiddlewareDispatcher::class);
        $consumer->set('MiddlewareDispatcher', $dispatcher);
    }
}

