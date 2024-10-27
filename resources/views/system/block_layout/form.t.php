<tpl extends="layouts/page" title="Block Layout Form">
  <tpl slot="action">
    <button form="form-block-layout">Save</button>
  </tpl>
  <tpl slot="default">
    <form id="form-block-layout" p-bind="$form_block_layout" method="POST">
      <div class="form-group row mb-3">
        <label class="col-sm-3 col-form-label">Code</label>
        <div class="col-sm-9">
          <input type="text" p-model="code" class="form-control">
        </div>
      </div>
      <div class="form-group row mb-3">
        <label class="col-sm-3 col-form-label">Model</label>
        <div class="col-sm-9">
          <select name="model" class="form-control">
            <option p-foreach="$model_options as $option" :value="$option['value']">{{ $option['label'] }}</option>
          </select>
        </div>
      </div>
      <input type="hidden" name="data">
    </form>
    <div id="htme-editor"></div>
  </tpl>
  <tpl slot="scripts">
    <script src="http://localhost:8003/main.bundle.js"></script>

    <script>
      window.editor = new VueLayoutEditor();

      editor.use(htmeBootstrap5, {
        module: "default"
      })

      editor.addLanguage({
        code: "ro",
        name: "Romana",
        icon: '<img src="https://flagpedia.net/data/flags/w702/ro.webp">'
      });

      editor.addLanguage({
        code: "en",
        name: "English",
        icon: '<img src="https://flagpedia.net/data/flags/w702/gb.webp">'
      });
    </script>
    <script p-if="$MODEL">
      editor.setData({!! json_encode($MODEL->data); !!});
    </script>
    <script>
      editor.mount("#htme-editor");
      
      $('#form-block-layout').on('submit', function() {
        let data = editor.getData();
        let json = JSON.stringify(data);
        $(this).find('input[name="data"]').val(json);
      });
    </script>
  </tpl>
</tpl>