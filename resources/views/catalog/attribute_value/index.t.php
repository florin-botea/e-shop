<x-crud resource="catalog/attribute/value" :params="['attribute_id' => $attribute_id]" :collection="$collection">
    <tpl slot="thead">
        <th>Name</th>
    </tpl>
    <tpl slot="default" p-scope="['item' => $item]">
        <td>{{ $item['value'] }} {{ $item['unit'] }}</td>
    </tpl>
</x-crud>