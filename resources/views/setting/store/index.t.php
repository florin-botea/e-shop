<tpl extends="layouts/page" title="Stores">
  <tpl slot="action">
    <x-btn-add route="setting/store/create"></x-btn-add>
  </tpl>
  <tpl slot="default">
      <x-index resource="setting/store" :collection="$collection">
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