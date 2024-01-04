<tpl extends="layouts/page" title="Attribute Groups">
  <tpl slot="action">
    <x-btn-add route="catalog/attribute_group/create"></x-btn-add>
  </tpl>
  <tpl slot="default">
      <x-index resource="catalog/attribute_group" :collection="$collection">
          <tpl slot="thead">
              <th>ID</th>
              <th>{t 'Name'}</th>
          </tpl>
          <tpl slot="default" p-scope="['item' => $item]">
              <td>{{ $item->id }}</td>
              <td>{{ $item['language']['name'] }}</td>
          </tpl>
      </x-index>
  </tpl>
</tpl>