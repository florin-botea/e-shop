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
        $keys = array_keys($parameters);
        $keys = array_map(function($key) {
            return preg_replace('/(_id)$/', '', $key);
        }, $keys);
        $keysRegexp = preg_replace('/[\-_]/', '[\-_]', implode('|', $keys));
        $uri = preg_replace_callback("/($keysRegexp)([\/])/", function($m) use (&$parameters) {
            $return = $m[1] . '/' . $parameters[$m[1] . '_id'] . '/';
            unset($parameters[$m[1] . '_id']);
            return $return;
        }, $name);
  
        $uri = $this->to($uri, [], $secure);

        if (! empty($parameters)) {
            $uri .= '?'.http_build_query($parameters);
        }

        return $uri;
    }
}