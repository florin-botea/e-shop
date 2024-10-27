<tpl extends="layouts/page" title="Entity Form">
  <tpl slot="action">
    <button form="form-block-layout">Save</button>
  </tpl>
  <tpl slot="default">
    <form id="form-block-layout" p-bind="$form_entity" method="POST">
      <div class="form-group row mb-3">
        <label class="col-sm-3 col-form-label">Namespace</label>
        <div class="col-sm-9">
          <input type="text" p-model="namespace" class="form-control">
        </div>
      </div>
      <div class="form-group row mb-3">
        <label class="col-sm-3 col-form-label">Name</label>
        <div class="col-sm-9">
          <input type="text" p-model="name" class="form-control">
        </div>
      </div>
      <div class="form-group row mb-3">
        <label class="col-sm-3 col-form-label">Class</label>
        <div class="col-sm-9">
          <input type="text" p-model="class" class="form-control">
        </div>
      </div>
      <div class="form-group row mb-3">
        <label class="col-sm-3 col-form-label">Table</label>
        <div class="col-sm-9">
          <input type="text" p-model="table" class="form-control">
        </div>
      </div>
      <caption>Entity Properies</caption>
      <table class="table" id="entity-properties">
        <thead>
          <td>name</td>
          <td>code</td>
          <td>type</td>
          <td>default</td>
          <td>length</td>
          <td>index</td>
          <td></td>
        </thead>
        <tbody>
          <tpl is="system/entity/form_property" p-foreach="$entity->properties as $i => $property" :item="$property" :i="$i"></tpl>
        </tbody>
        <tfoot>
          <tr>
            <td colspan="100%" class="text-end">
              <button type="button" class="btn btn-sm btn-primary" onclick="addProperty()"><i class="fa fa-plus"></i></button>
            </td>
          </tr>
        </tfoot>
      </table>
    </form>
  </tpl>
  <script slot="scripts">
    function addProperty() {
      let template = `{!! view('system/entity/form_property', ['item' => $new_entity_property, 'i' => '__index__']) !!}`;

      let lastProperty = $('#entity-properties tbody tr').last();
      let index = 0;
      if (lastProperty.length) {
        index = lastProperty.attr('id').replace('entity-property-', '');
        index++;
      }

      template = template.replaceAll('__index__', index);

      $('#entity-properties tbody').append(template);
    };
  </script>
</tpl>