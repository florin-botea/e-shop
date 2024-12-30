<tr id="entity-property-{{ $i }}">
  <td><input type="text" name="properties[{{ $i }}][table_column_id]" :value="$item['table_column_id']" class="form-control" placeholder="column"></td>
  <td><input type="text" name="properties[{{ $i }}][code]" :value="$item['code']" class="form-control" placeholder="code"></td>
  <td class="text-end">
    <input type="hidden" name="properties[{{ $i }}][id]" :value="$item['id']">
    <button type="button" class="btn btn-sm btn-danger" onclick="$(this).closest('tr').remove()"><i class="fa fa-trash"></i></button>
  </td>
</tr>