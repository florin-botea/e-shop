<tpl extends="layouts/page" title="Product Form">
  <tpl slot="action">
    <btn-save form="form"></btn-save>
    <btn-cancel></btn-cancel>
  </tpl>
  <tpl slot="default">
      <x-panel :title="$title">{% dump($errors) %}
        <x-form :action="$action" :method="$method" id="product-form" p-share="['MODEL' => $model]" multilang>
          <x-tabs :items="$tabs" id="product-form-tabs">
            <tpl slot="tabs"></tpl>
          </x-tabs>
        </x-form>
      </x-panel>
  </tpl>
</tpl>

<?php

use App\Support\Dom;

return new class
{
    public function parsing($node)
    {
        $node->addTab('general', 'catalog/product/partials/form/general');
    }

    public function nodeAddTab($node, $key, $view, $before = null)
    {
        static $ref;
        if (! $ref) {
            $ref = $node->querySelector('#product-form-tabs');
        }

        Dom::addTab($ref, $key, $view, $before);
    }
};