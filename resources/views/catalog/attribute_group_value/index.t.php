<x-crud resource="catalog/attribute_group/value" :params="['attribute_group_id' => $attribute_group_id]" :collection="$collection">
    <tpl slot="thead">
        <th>Name</th>
    </tpl>
    <tpl slot="default" p-scope="['item' => $item]">
        <td>{{ $item['attribute']['language']['name'] }}</td>
    </tpl>
</x-crud>