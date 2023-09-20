<tpl extends="layouts/page" title="Products">
  <tpl slot="action">
    <x-btn-add></x-btn-add>
  </tpl>
  <tpl slot="default">
      <x-index resource="catalog/product" :collection="$collection">
          <tpl slot="thead">
              <th>ID</th>
              <th>{t 'Name'}</th>
          </tpl>
          <tpl slot="default" p-scope="['item' => $item]">
              <td>{{ $item->id }}</td>
              <td>{{ $item->description->name }}</td>
          </tpl>
      </x-index>
  </tpl>
</tpl>