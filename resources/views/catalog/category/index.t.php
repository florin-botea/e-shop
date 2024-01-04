<tpl extends="layouts/page" title="Categories">
  <tpl slot="action">
    <x-btn-add route="catalog/category/create"></x-btn-add>
  </tpl>
  <tpl slot="default">
      <x-index resource="catalog/category" :collection="$collection">
          <tpl slot="thead">
              <th>ID</th>
              <th>{t 'Name'}</th>
          </tpl>
          <tpl slot="default" p-scope="['item' => $item]">
              <td>{{ $item->id }}</td>
              <td>{{ $item->name }}</td>
          </tpl>
      </x-index>
  </tpl>
</tpl>