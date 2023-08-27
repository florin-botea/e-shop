<?php

namespace PsrRouting;

class RouteDispatcher
{
    public function dispatch($method, $pathInfo) 
    {
        dd($method, $pathInfo);
    }
}
