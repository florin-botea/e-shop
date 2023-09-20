<?php 

namespace PsrRouting;
 
use Laravel\Lumen\Routing\UrlGenerator as BaseUrlGenerator;
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
    
    public function route($name, $parameters = [], $secure = null)
    {
        $name = str_replace('.', '/', $name);
        $parts = explode('/', $name);
        $uri = [];
        
        if (end($parts) == 'update') {
            array_pop($parts);
            $parameters['_method'] = 'PUT';
        }
        
        foreach ($parts as $part) {
            $paramKey = str_replace('-', '_', $part) . '_id';
            $uri[] = $part;
            if (isset($parameters[$paramKey])) {
                $uri[] = $parameters[$paramKey];
                unset($parameters[$paramKey]);
            }
        }

        $uri = implode('/', $uri);
        $uri = $this->to($uri, [], $secure);

        if (! empty($parameters)) {
            $uri .= '?'.http_build_query($parameters);
        }

        return $uri;
    }
}