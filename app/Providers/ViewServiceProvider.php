<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use PhpTemplates\PhpTemplates;
use App\Models\Localisation\Language;
use App\Models\Setting\Store;

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
        
        $templates->share('STORES', function() {
            $Store = $this->app->make(Store::class);
            return $Store->all();
        });
        
        $templates->share('WINDOW_VARS', [
            'base_url' => url('/admin'),
            'items_per_page' => 20,
        ]);
        
        $config = $templates->config();
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
            
            if (strstr($node->getAttribute('is'), '/form-check')) {
                $node->setAttribute(':checked', "old('$params', data_get(\$_model, '$params'))");
            }
            elseif (!$node->hasAttribute('value') && !$node->hasAttribute(':value')) {
                if ($node->getAttribute('type') == 'multilang') {
                $name = $node->getAttribute('name');
                // trim last, replace it with 'languages'
                $temp = preg_split('/[\[\]]/', $name, -1, PREG_SPLIT_NO_EMPTY);
                $temp[count($temp) -1] = 'languages';
                $name = implode('.', $temp);
                $node->setAttribute(':value', "old('$name', data_get(\$_model, '$name'))");
                } else {
                    $node->setAttribute(':value', "old('$params', data_get(\$_model, '$params'))");
                }               
            }
            
            if (!$node->hasAttribute('error') && !$node->hasAttribute(':error')) {
                $node->setAttribute(':error', "\$errors->first('$params')");
            }
        });
    }
}
