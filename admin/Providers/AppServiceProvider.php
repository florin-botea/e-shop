<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function boot()
    {
        // list all files from root model
        // list all files from admin model
        $this->app->bind(PhpTemplates::class, function($app) {
            return $app['phpt'];
        });
    }
}
