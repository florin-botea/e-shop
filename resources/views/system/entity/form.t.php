<tpl extends="layouts/page" title="Entity Form">
  <tpl slot="action">
    <button form="form-entity">Save</button>
  </tpl>
  <tpl slot="default">
    {% dump($tables->toArray()) %}
    <form id="form-entity" p-bind="$form_entity" method="POST">
      <div class="form-group row mb-3">
        <label class="col-sm-3 col-form-label">Code</label>
        <div class="col-sm-9">
          <input type="text" p-model="code" class="form-control">
        </div>
      </div>
      <div class="form-group row mb-3">
        <label class="col-sm-3 col-form-label">Name</label>
        <div class="col-sm-9">
          <input type="text" p-model="name" class="form-control">
        </div>
      </div>
      <div class="form-group row mb-3">
        <label class="col-sm-3 col-form-label">Description</label>
        <div class="col-sm-9">
          <input type="text" p-model="description" class="form-control">
        </div>
      </div>
      <div class="form-group row mb-3">
        <label class="col-sm-3 col-form-label">Table</label>
        <div class="col-sm-9">
          <select type="text" p-model="table_id" class="form-control">
            <option p-foreach="$tables as $table" :value="$table->id" p-selected="$table->id == $entity->table_id">{{ $table->name }}</option>
          </select>
        </div>
      </div>
      <caption>Entity Properties</caption>
      <table class="table" id="entity-properties">
        <thead>
          <td>column</td>
          <td>code</td>
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
      
      <caption>Entity Relationships</caption>
      <table class="table" id="entity-relationships">
        <thead>
          <td>relationship</td>
          <td>name</td>
          <td>entity</td>
          <td>local key</td>
          <td>foreign key</td>
          <td>pivot</td>
          <td>pivot local key</td>
          <td>pivot foreign key</td>
          <td></td>
        </thead>
        <tbody>
          <tpl is="system/entity/form_relationship" p-foreach="$entity->relationships as $i => $relationship" :item="$relationship" :i="$i"></tpl>
        </tbody>
        <tfoot>
          <tr>
            <td colspan="100%">
              <div class="input-group d-flex justify-content-end">
                <select class="form-control" style="max-width: 180px">
                  <option value="hasOne">hasOne</option>
                  <option value="hasMany">hasMany</option>
                  <option value="hasOneThrought">hasOneThrought</option>
                  <option value="hasManyThrought">hasManyThrought</option>
                </select>
                <button type="button" class="btn btn-sm btn-primary" onclick="addRelationship()"><i class="fa fa-plus"></i> Add Relationship</button>
              </div>
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

    async function addRelationship() {
      let lastRelationship = $('#entity-relationships tbody tr').last();
      let index = 0;
      if (lastRelationship.length) {
        index = lastRelationship.attr('id').replace('entity-relationship-', '');
        index++;
      }

      let template = await view('system/entity/form_relationship', {
        i: index,
        item: { relationship: 'hasMany' }
      })

      $('#entity-relationships tbody').append(template);
    };
  </script>
</tpl>