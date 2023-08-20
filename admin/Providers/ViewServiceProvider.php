<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use PhpTemplates\PhpTemplates;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function boot(PhpTemplates $templates)
    {
        $config = $templates->getConfig();
        
        $config->helper('t', function($t, $params) {
            return $params;
        });
    }
}
