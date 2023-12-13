<?php

namespace PsrRouting;

use Illuminate\Support\ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class RoutingServiceProvider extends ServiceProvider
{
    private $methodVerbs = [
        'index' => ['GET',
            'HEAD'],
        'show' => ['GET',
            'HEAD'],
        'create' => ['GET',
            'HEAD'],
        'edit' => ['GET',
            'HEAD'],
        'store' => ['POST'],
        'update' => ['PUT',
            'PATCH'],
        'destroy' => ['DELETE'],
    ];

    public function boot(Request $request) {
        $method = $this->getControllerMethod($request);
        $uri = $this->getUri($request);
        $controller = $this->getControllerClass($request->getPathInfo());

        $uses = $controller.'@'.$method;
        if (method_exists($controller, '__invoke')) {
            $uses = $controller;
        }

        // todo if class exists
        $this->app->router->addRoute($this->methodVerbs[$method], $uri, [
            'uses' => $uses
        ]);
    }

    private function getControllerClass($path) {
        // todo check if multiple calls and cache needed
        $path = trim($path, '/') ?: '/';
        $chunks = explode('/', $path);

        if (empty($chunks)) {
            return "App\\Http\\Controllers\\HomepageController";
        }

        if ($chunks[0] == 'admin' && count($chunks) === 1) {
            return 'App\\Http\\Controllers\\DashboardController';
        }

        if (in_array(end($chunks), ['create', 'edit'])) {
            array_pop($chunks);
        }

        $chunks = array_filter($chunks, fn($chunk) => !is_numeric($chunk['0'] ?? ''));
        $chunks = array_values($chunks);
        $paths = array_map(fn($chunk) => ucfirst(Str::camel($chunk)), $chunks);
        $paths[count($paths) -1] .= 'Controller';

        $basePath = 'App\\Controllers\\';
        if ($paths[0] == 'Admin') {
            $basePath = 'App\\Admin\\Controllers\\';
            array_shift($paths);
            $paths = array_values($paths);
        }

        // try to find controller with multiple combinations
        for ($iTry = 0; $iTry < count($paths); $iTry++) {
            $_paths = $paths;
            $class = $basePath;
            foreach ($_paths as $i => $path) {
                if ($i == $iTry) {
                    $class .= implode('', $_paths);
                    break;
                }
                $class .= $path . '\\';
                unset($_paths[$i]);
            }

            if (class_exists($class)) {
                return $class;
            }
        }
        dd('404');
    }

    private function getControllerMethod($request) {
        $path = trim($request->getPathInfo(), '/') ?: '/';
        $chunks = explode('/', $path);
        $endChunk = end($chunks);

        if (is_numeric($endChunk[0] ?? '')) {
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

    private function getUri($request) {
        $path = trim($request->getPathInfo(), '/') ?: '/';
        $lastChunk = null;
        return implode('/', array_map(function($p) use (&$lastChunk) {
            if (is_numeric($p[0] ?? '') && $lastChunk) {
                $this->parameters[$lastChunk . '_id'] = $p;
                return '{' . $lastChunk . '_id}';
            }
            $lastChunk = str_replace('-', '_', $p);
            return $p;
        },
            explode('/', $path)));
    }
}