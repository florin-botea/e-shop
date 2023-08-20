<?php 

namespace PsrRouting;
 
use Illuminate\Routing\UrlGenerator as BaseUrlGenerator;
use App\Routing\RouteCollection;
use Illuminate\Container\Container;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Routing\Route;

class UrlGenerator extends BaseUrlGenerator
{
    // @todo duplicate
    private $methodVerbs = [
        'index' => ['GET', 'HEAD'],
        'show' => ['GET', 'HEAD'],
        'create' => ['GET', 'HEAD'],
        'edit' => ['GET', 'HEAD'],
        'store' => ['POST'],
        'update' => ['PUT', 'PATCH'],
        'destroy' => ['DELETE'],
    ];    
    
    public function route($name, $parameters = [], $absolute = true)
    {
        if ($this->routes->getByName($name)) {
            return parent::route($name, $parameters, $absolute);
        }

        $name = explode('.', $name);
        $method = 'index';
        if (isset($name[1])) {
            $method = $name[1];
        }
        $name = $name[0];
       
        $uri = [];
        foreach (explode('/', $name) as $part) {
            $uri[] = $part;
            if (isset($parameters[$part])) {
                $uri[] = '{' . $part . '?}';
            }
        }
        $uri = implode('/', $uri);
        $controller = $this->_getControllerClass($name);
        $route = new Route($this->methodVerbs[$method], $uri, ['uses' => $controller.'@'.$method]);
     //todo tipa daca m nu e in array   
        return $this->toRoute($route, $parameters, $absolute);
    }
    
    // @todo duplicate
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
}