<tpl extends="layouts/page" title="Attribute Form">
    <tpl slot="action">
        <x-btn-save form="attribute-form"></x-btn-save>
        <x-btn-cancel></x-btn-cancel>
    </tpl>
    <tpl slot="default">
        <x-panel :title="$title">
            <x-form id="attribute-form">
                <input type="hidden" name="_form_id" :value="$form_id">
          <x-tabs id="attribute-form-tabs">
            <tpl slot="tabs">
                <x-tab-item value="general" active>{t 'General'}</x-tab-item>
                <x-tab-item value="description">{t 'Description'}</x-tab-item>
                <x-tab-item value="values">{t 'Values'}</x-tab-item>
            </tpl>

            <div slot="general">
                {!! form('attribute_form', $_model) !!}
                <!-- fieldset>
                  <legend>{t 'Data'}</legend>
                  <x-form-group p-model="code" />            
                  <x-form-check p-model="config.value.required" />
                  <x-form-check p-model="config.value.multilang" />
                  <x-form-group p-model="unit_field" type="select" :options="$field_type_options" id="unit_field" blank="{t 'none'}" />
                  <div id="unit-field-config">{!! $unit_field_config !!}</div>
                  <x-form-group p-model="sort_order" type="number" />
                </fieldset -->                
            </div>  
            <div slot="description">
                <tpl is="catalog/attribute_language/index" :attribute_id="$form_id"></tpl>
            </div>
            <div slot="values">
                <div p-if="! $_model->id" class="alert alert-warning">
                    {t 'In order to add predefined values, you have to save the form first'}
                </div>
                <tpl p-else>
                    <tpl is="catalog/attribute_value/index" :attribute_id="$_model->id"></tpl>
                </tpl>
            </div>
          </x-tabs>
            </x-form>
        </x-panel>
    </tpl>
</tpl>