<tpl extends="layouts/page" title="Forms">
  <tpl slot="action">
    <x-btn-add route="setting/form/create" modal></x-btn-add>
  </tpl>
  <tpl slot="default">
      <x-index resource="setting/form" :collection="$collection">
          <tpl slot="thead">
              <th>ID</th>
              <th>{t 'Name'}</th>
          </tpl>
          <tpl slot="default" p-scope="['item' => $item]">
              <td>{{ $item->id }}</td>
              <td>{{ $item['name'] ?? '' }}</td>
          </tpl>
      </x-index>
  </tpl>
</tpl>