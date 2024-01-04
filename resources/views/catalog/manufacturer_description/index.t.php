<x-crud resource="catalog/manufacturer/description" :params="['manufacturer_id' => $manufacturer_id, 'store_id' => $store_id]" :collection="$collection">
    <tpl slot="thead">
        <th>Locale</th>
        <th>Name</th>
    </tpl>
    <tpl slot="default" p-scope="['item' => $item]">
        <td>{{ $item['language_id'] }}</td>
        <td>{{ $item['name'] }}</td>
    </tpl>
</x-crud>