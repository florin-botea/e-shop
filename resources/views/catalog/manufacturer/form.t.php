<tpl extends="layouts/page" title="Manufacturer Form">
  <tpl slot="action">
    <x-btn-save form="manufacturer-form"></x-btn-save>
    <x-btn-cancel></x-btn-cancel>
  </tpl>
  <tpl slot="default">
      <x-panel :title="$title">{% dump($errors) %}
        <x-form id="manufacturer-form">
          <x-tabs id="manufacturer-form-tabs">
            <tpl slot="tabs">
                <x-tab-item value="general" active>{t 'General'}</x-tab-item>
                <x-tab-item value="description">{t 'Description'}</x-tab-item>
            </tpl>

            <div slot="general">
                <fieldset>
                  <legend>{t 'Data'}</legend>
                  <x-form-group p-model="name" />            
                  <x-form-group p-model="image" />            
                  <x-form-group p-model="sort_order" type="number" />            
                </fieldset>                
            </div>  
            <div slot="description">
                <x-tabs id="tab-descriptions">
                    <tpl slot="tabs">
                        {% $i = 0 %}
                        <x-tab-item p-foreach="$STORES as $store" :value="'store'.$store->id" :active="$i == 0">
                            {% $i++ %}
                            {{ $store->name }}
                        </x-tab-item>
                    </tpl>
                    <tpl slot="default">
                        {% $i = 0 %}
                        <div p-foreach="$STORES as $store" class="tab-pane" :class="['show active' => $i == 0]" :id="'store'.$store->id" role="tabpanel" :aria-labelledby="'store'.$store->id.'-tab'">
                            {% $i++ %}
                            <tpl is="catalog/manufacturer_description/index" :manufacturer_id="$_model->id" :store_id="$store->id"></tpl>
                        </div>
                    </tpl>
                </x-tabs>
            </div>
          </x-tabs>
        </x-form>
      </x-panel>
  </tpl>
</tpl>

<?php

use App\Support\Dom;

return new class
{
    public function nodeAddTab($node, $key, $view, $before = null)
    {
        static $ref;
            $ref = $node->querySelector('#manufacturer-form-tabs');
        if (! $ref) {
        }

        Dom::addTab($ref, $key, $view, $before);
    }
};