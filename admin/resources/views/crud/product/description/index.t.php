<x-crud :collection="$collection" :resource="'catalog/product/'.$_model->id.'/description'">
    <tpl slot="thead">
        <th>Locale</th>
        <th>Name</th>
    </tpl>
    <tpl slot="default" p-scope="['item' => $item]">
        <td>{{ $item['language_id'] }}</td>
        <td>{{ $item['name'] }}</td>
    </tpl>
</x-crud>