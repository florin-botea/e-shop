<tpl extends="layouts/page" title="Product Form">
  <tpl slot="action">
    <x-btn-save form="product-form"></x-btn-save>
    <x-btn-cancel></x-btn-cancel>
  </tpl>
  <tpl slot="default">
      <x-panel :title="$title">{% dump($errors) %}
        <x-form :action="$action" id="product-form">
          <x-tabs id="product-form-tabs">
            <tpl slot="tabs">
                <x-tab-item value="general" active>{t 'General'}</x-tab-item>
                <x-tab-item value="description">{t 'Description'}</x-tab-item>
            </tpl>
            
            <tpl slot="general" include="catalog/product/partials/form/general"></tpl>
            <tpl slot="description" include="crud/product/description/index"></div>
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
        // $node->addTab('general', 'catalog/product/partials/form/general');
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