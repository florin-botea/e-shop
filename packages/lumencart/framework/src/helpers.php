<?php

if (! function_exists('redirect')) {
    /**
     * Get an instance of the redirector.
     *
     * @param  string|null  $to
     * @param  int  $status
     * @param  array  $headers
     * @param  bool|null  $secure
     * @return \Laravel\Lumen\Http\Redirector|\Illuminate\Http\RedirectResponse
     */
    function redirect($to = null, $status = 302, $headers = [], $secure = null)
    {
        $redirector = new LumenCart\Http\Redirector(app());

        if (is_null($to)) {
            return $redirector;
        }

        return $redirector->to($to, $status, $headers, $secure);
    }
}

if (! function_exists('csrf_token')) {
    function csrf_token() {
        return request()->session()->get('_token');
    }
}

if (! function_exists('session')) {
    function session() {
        return request()->session();
    }
}

if (! function_exists('model')) {
    function model($model, $extends = null) {
        return app()->model($model, $extends);
    }
}

if (! function_exists('form')) {
    function form($code, $data = []) {
        return new App\View\Form($code, $data);
    }
}

if (! function_exists('old')) {
    function old($key, $fallback) {
        return session()->getOldInput($key, $fallback);
    }
}
    
    
if (! function_exists('get_dir_contents')) {
    function get_dir_contents($dir, &$results = array()) {
        $files = scandir($dir);
    
        foreach ($files as $key => $value) {
            $path = realpath($dir . DIRECTORY_SEPARATOR . $value);
            if (!is_dir($path)) {
                $results[] = $path;
            } else if ($value != "." && $value != "..") {
                get_dir_contents($path, $results);
                $results[] = $path;
            }
        }
    
        return $results;
    }
}

if (! function_exists('get_dir_classes')) {
    function get_dir_classes($dir, $namespace) {
        $namespace = trim($namespace, '\\');
        $classes = [];
        foreach (get_dir_contents($dir) as $path) {
            if (is_file($path) && strpos($path, '.php')) {
                $class = str_replace([$dir, '/', '.php'], ['', '\\', ''], $path);
                $name = array_map(fn($str) => Illuminate\Support\Str::snake($str), explode('\\', $class));
                $name = implode('/', $name);
                $classes[] = "$namespace\\" . trim($class, '\\');
            }
        }
        
        return $classes;
    }
}

if (! function_exists('model_name')) {
    function model_name($class) {
        if (!is_string($class)) {
            $class = get_class($class);
        }
        
        $name = str_replace('App\\Models\\', '', $class);
        $parts = explode('\\', $name);
        $parts = array_map(fn($part) => Illuminate\Support\Str::snake($part), $parts);
        $name = implode('/', $parts);
        
        return $name;
    }
}
    