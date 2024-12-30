<tr id="entity-relationship-{{ $i }}">
  <td>
    <input type="hidden" name="relationships[{{ $i }}][id]" :value="$item['id']">
    <input type="hidden" name="relationships[{{ $i }}][relationship]" :value="$item['relationship']">
    {{ $item['relationship'] }}
  </td>
  <td><input type="text" name="relationships[{{ $i }}][name]" :value="$item['name']" class="form-control" placeholder="column"></td>
  <td><input type="text" name="relationships[{{ $i }}][entity_id]" :value="$item['entity_id']" class="form-control" placeholder="entity"></td>
  <td class="text-end">
    <button type="button" class="btn btn-sm btn-danger" onclick="$(this).closest('tr').remove()"><i class="fa fa-trash"></i></button>
  </td>
</tr>