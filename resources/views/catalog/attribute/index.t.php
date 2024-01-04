<tpl extends="layouts/page" title="Attributes">
  <tpl slot="action">
    <x-btn-add route="catalog/attribute/create"></x-btn-add>
  </tpl>
  <tpl slot="default">
      <x-index resource="catalog/attribute" :collection="$collection">
          <tpl slot="thead">
              <th>ID</th>
              <th>{t 'Name'}</th>
          </tpl>
          <tpl slot="default" p-scope="['item' => $item]">
              <td>{{ $item->id }}</td>
              <td>{{ $item['language']['name'] ?? '' }}</td>
          </tpl>
      </x-index>
  </tpl>
</tpl>