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
                <x-tab-item value="values">{t 'Values'}</x-tab-item>
            </tpl>

            <div slot="general">
                {!! form('attribute_form', $_model) !!}
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