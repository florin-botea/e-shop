<?php 

namespace PsrRouting;
 
use Laravel\Lumen\Routing\Router as BaseRouter;
use Illuminate\Container\Container;
use Illuminate\Contracts\Events\Dispatcher;

class Router extends BaseRouter
{
    // @override
    public function __construct(Container $container = null)
    {

    }    
}