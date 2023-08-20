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
                $node->setAttribute(':value', 123); // TODO
            }
        });
    }
}
