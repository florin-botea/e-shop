<tpl extends="layouts/page" title="Attribute Group Form">
    <tpl slot="action">
        <x-btn-save form="attribute-group-form"></x-btn-save>
        <x-btn-cancel></x-btn-cancel>
    </tpl>
    <tpl slot="default">
        <x-panel :title="$title">
            <x-form id="attribute-group-form">
                <input type="hidden" name="_form_id" :value="$form_id">
          <x-tabs id="attribute-group-form-tabs">
            <tpl slot="tabs">
                <x-tab-item value="general" active>{t 'General'}</x-tab-item>
                <x-tab-item value="language">{t 'Description'}</x-tab-item>
                <x-tab-item value="values">{t 'Values'}</x-tab-item>
            </tpl>

            <div slot="general">
                <fieldset>
                  <legend>{t 'Data'}</legend>
                  <x-form-group p-model="code" />            
                  <x-form-group p-model="sort_order" type="number" />
                </fieldset>                
            </div>  
            <div slot="language">
                <tpl is="catalog/attribute_group_language/index" :attribute_group_id="$form_id"></tpl>
            </div>
            <div slot="values">
                <div p-if="! $_model->id" class="alert alert-warning">
                    {t 'In order to add predefined values, you have to save the form first'}
                </div>
                <tpl p-else>
                    <tpl is="catalog/attribute_group_value/index" :attribute_group_id="$_model->id"></tpl>
                </tpl>
            </div>
          </x-tabs>
            </x-form>
        </x-panel>
    </tpl>
</tpl>