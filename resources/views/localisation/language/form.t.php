<tpl extends="layouts/page" title="Languages Form">
  <tpl slot="action">
    <x-btn-save form="language-form"></x-btn-save>
    <x-btn-cancel></x-btn-cancel>
  </tpl>
  <tpl slot="default">
      <x-panel :title="$title">{% dump($errors) %}
        <x-form :action="$formAction" id="language-form">
            <fieldset>
              <legend>{t 'Data'}</legend>
              <x-form-group p-model="name" />
              <x-form-group p-model="code" />
              <x-form-check p-model="status" type="switch" /> 
            </fieldset>                
          </x-tabs>
        </x-form>
      </x-panel>
  </tpl>
</tpl>