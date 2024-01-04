<tpl extends="layouts/page" title="Product Form">
  <tpl slot="action">
    <x-btn-save form="product-form"></x-btn-save>
    <x-btn-cancel></x-btn-cancel>
  </tpl>
  <tpl slot="default">
      <x-panel :title="$title">{% dump($errors) %}
        <x-form :action="route('admin/catalog/product/update', ['product_id' => $_model->id])" id="product-form">
          <x-tabs id="product-form-tabs">
            <tpl slot="tabs">
                <x-tab-item value="general" active>{t 'General'}</x-tab-item>
                <x-tab-item value="description">{t 'Description'}</x-tab-item>
            </tpl>

            <div slot="general">
                <fieldset>
                  <legend>{t 'Data'}</legend>
                  <x-form-group p-model="model" />            
                  <x-form-group p-model="sku" />            
                  <x-form-group p-model="upc" />            
                  <x-form-group p-model="ean" />            
                  <x-form-group p-model="jan" />            
                  <x-form-group p-model="isbn" />            
                  <x-form-group p-model="mpn" />            
                  <x-form-check p-model="shipping" type="switch" /> 
                  <div class="row">
                      <x-form-group class="col-sm-3" p-model="volumetry.length" />            
                      <x-form-group class="col-sm-3" p-model="volumetry.width" />            
                      <x-form-group class="col-sm-3" p-model="volumetry.height" />            
                      <x-form-group class="col-sm-3" p-model="volumetry.weight" />            
                      <x-form-group class="col-sm-3" p-model="volumetry.length_class_id" />            
                      <x-form-group class="col-sm-3" p-model="volumetry.weight_class_id" />            
                  </div>
                  <x-form-check p-model="status" type="switch" />
                  <x-form-group p-model="sort_order" type="number"/>
                </fieldset>                
            </div>  
            <div slot="description">
                <x-crud :resource="'catalog/product/'.$_model->id.'/description'">
                    <tpl slot="thead">
                        <th>Locale</th>
                        <th>Name</th>
                    </tpl>
                    <tpl slot="default" p-scope="['item' => $item]">
                        <td>{{ $item['language_id'] }}</td>
                        <td>{{ $item['name'] }}</td>
                    </tpl>
                </x-crud>                
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