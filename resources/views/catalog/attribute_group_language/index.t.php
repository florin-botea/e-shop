<x-crud resource="catalog/attribute_group/language" :params="['attribute_group_id' => $attribute_group_id]" :collection="$collection">
    <tpl slot="thead">
        <th>Locale</th>
        <th>Name</th>
    </tpl>
    <tpl slot="default" p-scope="['item' => $item]">
        <td>{{ $item['language_id'] }}</td>
        <td>{{ $item['name'] }}</td>
    </tpl>
</x-crud>