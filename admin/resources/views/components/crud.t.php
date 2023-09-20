{% $id = 'crud_' . uniqid() %}
<div :id="$id">
    <div class="text-end">
        <x-btn-add type="button" class="lm-crud-create"></x-btn-add>
    </div>
    
    <table class="table lm-table-loading"></table>
        
    <div class="table-wrapper">
        <table class="table">
          <thead>
            <tr>
                <slot name="thead"></slot>
                <th>{t 'Action'}</th>
            </tr>
          </thead>
          <tbody p-if="isset($collection)">
            <tr p-foreach="$collection as $item" :data-item-id="$item['id']">
                <slot :item="$item"></slot>
                <td class="text-end">
                    <x-btn-edit type="button" class="lm-crud-edit"></x-btn-edit>
                    <x-btn-delete type="button" class="lm-crud-delete"></x-btn-delete>
                </td>
            </tr>
          </tbody>
        </table>
    </div>
    
    <x-modal class="lm-crud-modal">
        <tpl slot="footer">
            <x-btn-save class="lm-crud-submit"></x-btn-save>
        </tpl>
    </x-modal>
</div>

<script>
    let {{ $id }} = new Crud($('#{{ $id }}'), '{{ $resource }}', {{ json_encode($params) }});
    {{ $id }}.init({{ !isset($collection) ? 1 : 0 }});
</script>