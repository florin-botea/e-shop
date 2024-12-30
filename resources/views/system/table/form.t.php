<tpl extends="layouts/page" title="Table Form">
  <tpl slot="action">
    <button form="form-table">Save</button>
  </tpl>
  <tpl slot="default">
    <form id="form-table" p-bind="$form_table" method="POST">
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
      <caption>Table Columns</caption>
      <table class="table" id="table-columns">
        <thead>
          <td>type</td>
          <td>name</td>
          <td>description</td>
          <td>default</td>
          <td>length</td>
          <td>index</td>
          <td></td>
        </thead>
        <tbody>
          <tpl is="system/table/form_column" p-foreach="$table->columns as $i => $column" :item="$column" :i="$i"></tpl>
        </tbody>
        <tfoot>
          <tr>
            <td colspan="100%" class="text-end">
              <button type="button" class="btn btn-sm btn-primary" onclick="addColumn()"><i class="fa fa-plus"></i></button>
            </td>
          </tr>
        </tfoot>
      </table>
    </form>
  </tpl>
  <script slot="scripts">
    function addColumn() {
      let template = `{!! view('system/table/form_column', ['item' => $new_table_column, 'i' => '__index__']) !!}`;

      let lastColumn = $('#table-columns tbody tr').last();
      let index = 0;
      if (lastColumn.length) {
        index = lastColumn.attr('id').replace('table-column-', '');
        index++;
      }

      template = template.replaceAll('__index__', index);

      $('#table-columns tbody').append(template);
    };
  </script>
</tpl>