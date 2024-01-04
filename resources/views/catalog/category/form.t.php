<tpl extends="layouts/page" title="Category Form">
  <tpl slot="action">
    <x-btn-save form="category-form"></x-btn-save>
    <x-btn-cancel></x-btn-cancel>
  </tpl>
  <tpl slot="default">
      <x-panel :title="$title">
        <x-form id="category-form">
          <x-tabs id="category-form-tabs">
            <tpl slot="tabs">
                <x-tab-item value="general" active>{t 'General'}</x-tab-item>
                <x-tab-item value="description">{t 'Description'}</x-tab-item>
            </tpl>

            <div slot="general">
                <fieldset>
                  <legend>{t 'Data'}</legend>
                  <x-form-group p-model="code" />            
                  <x-form-group p-model="image" />            
                  <x-form-group p-model="sort_order" type="number" />            
                </fieldset>                
            </div>  
            <div slot="description">
                d
            </div>
          </x-tabs>
        </x-form>
      </x-panel>
  </tpl>
</tpl>