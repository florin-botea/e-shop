<tr id="table-column-{{ $i }}">
  <td><input type="text" name="columns[{{ $i }}][type]" :value="$item->type" class="form-control" placeholder="type"></td>
  <td><input type="text" name="columns[{{ $i }}][name]" :value="$item->name" class="form-control" placeholder="name"></td>
  <td><input type="text" name="columns[{{ $i }}][description]" :value="$item->description" class="form-control" placeholder="description"></td>
  <td><input type="text" name="columns[{{ $i }}][default]" :value="$item->default" class="form-control" placeholder="default"></td>
  <td><input type="text" name="columns[{{ $i }}][length]" :value="$item->length" class="form-control" placeholder="length"></td>
  <td><input type="checkbox" name="columns[{{ $i }}][index]" value="1" class="form-control" p-checked="$item->index"></td>
  <td class="text-end">
    <input type="hidden" name="columns[{{ $i }}][id]" :value="$item->id">
    <button type="button" class="btn btn-sm btn-danger" onclick="$(this).closest('tr').remove()"><i class="fa fa-trash"></i></button>
  </td>
</tr>