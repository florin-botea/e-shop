<x-crud resource="setting/form/field" :params="['form_id' => $form_id]" :collection="$collection">
    <tpl slot="thead">
        <th>Name</th>
    </tpl>
    <tpl slot="default" p-scope="['item' => $item]">
        <td>{{ $item['name'] }}</td>
    </tpl>
</x-crud>