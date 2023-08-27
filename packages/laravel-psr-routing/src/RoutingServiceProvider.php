<?php

namespace PsrRouting;

use Illuminate\Support\ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class RoutingServiceProvider extends ServiceProvider
{
    private $methodVerbs = [
        'index' => ['GET', 'HEAD'],
        'show' => ['GET', 'HEAD'],
        'create' => ['GET', 'HEAD'],
        'edit' => ['GET', 'HEAD'],
        'store' => ['POST'],
        'update' => ['PUT', 'PATCH'],
        'destroy' => ['DELETE'],
    ];
    
    public function boot(Request $request)
    {
        $method = $this->getControllerMethod($request);
        $uri = $this->getUri($request);
        $controller = $this->getControllerClass($request->getPathInfo());

        // todo if class exists
        $this->app->router->addRoute($this->methodVerbs[$method], $uri, ['uses' => $controller.'@'.$method]);
    }
    
    private function getControllerClass($path) 
    {
        // todo check if multiple calls and cache needed
        $path = trim($path, '/') ?: '/';
        $chunks = array_filter(explode('/', $path));
        
        if (empty($chunks)) {
            return 'App\\Http\\Controllers\\HomepageController';
        }
        
        if ($chunks[0] == 'admin' && count($chunks) === 1) {
            return 'App\\Http\\Controllers\\DashboardController';
        }
        
        if (in_array(end($chunks), ['create', 'edit'])) {
            array_pop($chunks);
        }

        if ($chunks[0] == 'admin') {
            array_shift($chunks);
        }
        
        $module = false;
        if ($chunks[0] == 'module') {
            array_shift($chunks);
            $module = array_shift($chunks);
            $module = $module && !is_numeric($module) ? ucfirst(Str::camel($module)) : false;
        }
        
        if ($module && !$chunks) { // module
            $controller = 'MainController';
        }
        else {
            $controller = array_filter($chunks, fn($chunk) => !is_numeric($chunk));
            $controller = array_map(fn($chunk) => ucfirst(Str::camel($chunk)), $controller);
            $controller = implode('\\', $controller) . 'Controller';
        }
        
        if ($module) {
            // todo check if module enabled or exists
            return 'Modules\\' . $module . '\\Controllers\\' . $controller;
        }
        
        return 'App\\Http\\Controllers\\' . $controller;
    }
    
    private function getControllerMethod($request)
    {
        $path = trim($request->getPathInfo(), '/') ?: '/';
        $chunks = explode('/', $path);
        $endChunk = end($chunks);
        
        if (is_numeric($endChunk)) {
            if ($request->isMethod('put')) {
                return 'update';
            }
            if ($request->isMethod('delete')) {
                return 'destroy';
            }
            return 'show';
        }
        
        if (in_array($endChunk, ['create', 'edit'])) {
            return $endChunk;
        }
        
        if ($request->isMethod('post')) {
            return 'store';
        }
        
        return 'index';
    }
    
    private function getUri($request) 
    {
        $path = trim($request->getPathInfo(), '/') ?: '/';
        $lastChunk = null;
        return implode('/', array_map(function($p) use (&$lastChunk) { 
            if (is_numeric($p) && $lastChunk) {
                $this->parameters[$lastChunk . '_id'] = $p;
                return '{' . $lastChunk . '_id}';
            }
            $lastChunk = str_replace('-', '_', $p);
            return $p;
        }, explode('/', $path)));
    }
}