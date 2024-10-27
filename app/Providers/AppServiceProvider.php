<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Schema\Builder;
use Illuminate\Support\Facades\Schema;
use App\Models\Localisation\Language;
use App\Models\Setting\Store;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        
        Builder::defaultStringLength(191);
        // list all files from root model
        // list all files from admin model
        $this->app->bind(PhpTemplates::class, function($app) {
            return $app['phpt'];
        });
        
        $this->app->singleton('languages', function() {
            $language = $this->app->make(Language::class);
            return Language::all();
        });
        
        $this->app->singleton('stores', function() {
            $Store = $this->app->make(Store::class);
            return $Store->all();
        });
        
        $this->app->singleton('length_classes', function() {
            $model = model('localisation/length_class');
            return $model->all();
        });
        
        $this->app->singleton('fields', function() {
            return new \App\View\Field;
        });
        
        
        $this->app->singleton('htme', function() {
            return new \App\View\Htme;
        });
        
        
        
        $this->commands([
            \App\Console\Commands\Remigrate::class
        ]);
    }
}
