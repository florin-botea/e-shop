<tpl extends="layouts/page" title="Form">
    <tpl slot="action">
        <x-btn-save form="form-form"></x-btn-save>
        <x-btn-cancel></x-btn-cancel>
    </tpl>
    <tpl slot="default">
        <x-panel :title="$title">
            <x-form id="form-form">
          <x-tabs id="form-form-tabs">
            <tpl slot="tabs">
                <x-tab-item value="general" active>{t 'General'}</x-tab-item>
                <x-tab-item value="fields" p-if="$_model->id">{t 'Fields'}</x-tab-item>
            </tpl>

            <div slot="general">
                <fieldset>
                  <legend>{t 'Data'}</legend>
                  <x-form-group p-model="code" />            
                  <x-form-group p-model="name" />
                </fieldset>                
            </div>  
            <div slot="fields" p-if="$_model->id">
                <tpl is="setting/form_field/index" :form_id="$_model->id"></tpl>
            </div>
          </x-tabs>
        <x-btn-save p-if="!$_model->id"></x-btn-save>
            </x-form>
        </x-panel>
    </tpl>
</tpl>