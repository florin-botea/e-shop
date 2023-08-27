<?php

namespace LumenCart;

use Laravel\Lumen\Application as BaseApplication;

class Application extends BaseApplication
{
    public function __construct($basePath = null)
    {
        $this->modelBindings();

        parent::__construct($basePath);
    }
    
    private function modelBindings() 
    {
        // todo cachw
        foreach (get_dir_contents(__DIR__ .'/Models') as $path) {
            if (is_file($path) && strpos($path, '.php')) {
                $class = str_replace([__DIR__, '/', '.php'], ['', '\\', ''], $path);
                $class = '\LumenCart' . $class;
                $this->availableBindings[$class] = $class;
            }
        }
    }
    
    protected function registerUrlGeneratorBindings()
    {
        $this->singleton('url', function () {
            return new \PsrRouting\UrlGenerator($this);
        });
    }
}