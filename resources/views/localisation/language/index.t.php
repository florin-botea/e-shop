<tpl extends="layouts/page" title="Languages">
  <tpl slot="action">
    <x-btn-add route="localisation/language/create"></x-btn-add>
  </tpl>
  <tpl slot="default">
      <x-index resource="localisation/language" :collection="$collection">
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