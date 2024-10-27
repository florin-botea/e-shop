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
      <tpl name="foo">
        <div class="item">
          {{ $item->name }}
        </div>
      </tpl>
    </form>
  </tpl>
</tpl>