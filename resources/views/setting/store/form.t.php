<tpl extends="layouts/page" title="Stores Form">
  <tpl slot="action">
    <x-btn-save form="store-form"></x-btn-save>
    <x-btn-cancel></x-btn-cancel>
  </tpl>
  <tpl slot="default">
      <x-panel :title="$title">{% dump($errors) %}
        <x-form :action="$formAction" id="store-form">
            <fieldset>
              <legend>{t 'Data'}</legend>
              <x-form-group p-model="name" />
              <x-form-group label="{t 'Languages'}">
                  <label p-foreach="$LANGUAGES as $language" class="d-block">
                      <input type="checkbox" name="language_ids[]" :value="$language->id" p-checked="in_array($language->id, $language_ids ?? [])"> {{ $language->name }}
                  </label>
              </x-form-group>
              <x-form-check p-model="status" type="switch" /> 
            </fieldset>                
          </x-tabs>
        </x-form>
      </x-panel>
  </tpl>
</tpl>