<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use PhpTemplates\PhpTemplates;
use LumenCart\Models\Localisation\Language;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function boot(PhpTemplates $templates)
    {
        $templates->share('LANGUAGES', function() {
            $language = $this->app->make(Language::class);
            return Language::all();
        });
        
        $templates->share('WINDOW_VARS', [
            'base_url' => url('/admin'),
            'items_per_page' => 20,
        ]);
        
        $config = $templates->getConfig();

        $config->helper('t', function($t, $params) {
            return $params;
        });

        $config->setDirective('model', function($node, $params) {
            if (!$node->hasAttribute('label') && !$node->hasAttribute(':label')) {
                $node->setAttribute('label', "{t '$params'}");
            }

            if (!$node->hasAttribute('name') && !$node->hasAttribute(':name')) {
                $parts = explode('.', $params);
                $name = '';
                foreach ($parts as $i => $part) {
                    if ($i > 0) {
                        $part = "[$part]";
                    }
                    $name .= $part;
                }
                $node->setAttribute('name', $name);
            }

            if (!$node->hasAttribute('id') && !$node->hasAttribute(':id')) {
                $node->setAttribute('id', str_replace('.', '-', $params));
            }

            if (!$node->hasAttribute('value') && !$node->hasAttribute(':value')) {
                $node->setAttribute(':value', "data_get(\$_model, '$params')");
            }
            
            if (!$node->hasAttribute('error') && !$node->hasAttribute(':error')) {
                $node->setAttribute(':error', "\$errors->first('$params')");
            }
        });
    }
}
