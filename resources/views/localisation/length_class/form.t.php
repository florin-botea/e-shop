<tpl extends="layouts/page" title="Length Class Form">
  <tpl slot="action">
    <x-btn-save form="length-class-form"></x-btn-save>
    <x-btn-cancel></x-btn-cancel>
  </tpl>
  <tpl slot="default">
      <x-panel :title="$title">{% dump($errors) %}
        <x-form :action="$formAction" id="length-class-form">
            <fieldset>
              <legend>{t 'Data'}</legend>
              <x-form-group p-model="name" />
              <x-form-group p-model="value" /> 
            </fieldset>                
          </x-tabs>
        </x-form>
      </x-panel>
  </tpl>
</tpl>