<?php

namespace PsrRouting;

use Illuminate\Routing\Route;
use Illuminate\Routing\RouteCollection as BaseRouteCollection;
use Illuminate\Routing\Events\Routing;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class RouteCollection extends BaseRouteCollection
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
   /* 
    public function __construct($request) 
    {
        $method = $this->_getControllerMethod($request);

        //parent::__construct($this->methodVerbs[$method], '*', []);
        
        $this->uri = $this->_getUri($request);
        $controller = $this->_getControllerClass($request);
        $this->action['uses'] = $controller.'@'.$method;
        dump($this->uri, $this->action['uses']);
    }
    
    /**
     * @override
     */
    protected function matchAgainstRoutes(array $routes, $request, $includingMethod = true)
    {
        if ($route = parent::matchAgainstRoutes($routes, $request, $includingMethod)) {
            return $route;
        }
        
        $method = $this->_getControllerMethod($request);
        $uri = $this->_getUri($request);
        $controller = $this->_getControllerClass($request->getPathInfo());
        
        //if (class_exists($controller)) {
            return new Route($this->methodVerbs[$method], $uri, ['uses' => $controller.'@'.$method]);
        //}//todo if debug mode, show error
    }
    
    private function _getControllerClass($path) 
    {
        // todo check if multiple calls and cache needed
        $path = trim($path, '/') ?: '/';
        $chunks = explode('/', $path);
        if (empty($chunks)) {
            return 'App\\Http\\Controllers\\Catalog\\HomepageController';
        }
        
        if ($chunks[0] == 'admin' && count($chunks) === 1) {
            return 'App\\Http\\Controllers\\Admin\\DashboardController';
        }
        
        if (in_array(end($chunks), ['create', 'edit'])) {
            array_pop($chunks);
        }
        
        $namespace = 'Catalog'; 
        if ($chunks[0] == 'admin') {
            $namespace = 'Admin';
            array_shift($chunks);
        }
        
        $module = false;
        if ($chunks[0] == 'module') {
            array_shift($chunks);
            $module = array_shift($chunks);
            $module = $module && !is_numeric($module) ? ucfirst(Str::camel($module)) : false;
        }
        
        $type = strpos($path, 'admin/') === 0 ? 'Admin' : 'Catalog';
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
            return 'Modules\\' . $module . '\\Controllers\\' . $type . '\\' . $controller;
        }
        
        return 'App\\Http\\Controllers\\' . $type . '\\' . $controller;
    }
    
    private function _getControllerMethod($request)
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
    
    private function _getUri($request) 
    {
        $path = trim($request->getPathInfo(), '/') ?: '/';
        $i = 0;
        return implode('/', array_map(function($p) use (&$i) { 
            if (is_numeric($p)) {
                $this->parameters['p'.$i] = $p;
                return '{p'.($i++).'}';
            }
            return $p;
        }, explode('/', $path)));
    }
}