{% $id = 'crud_' . uniqid() %}
<div :id="$id">
    <div class="text-end">
        <x-btn-add type="button" lm-crud-create></x-btn-add>
    </div>
    
    <table class="table" lm-table-loading>
        <tr>
            <td><div class="bg-fetch"><span class="btn invisible">x</span></div></td>
        </tr>
    </table>
        
    <div lm-crud-content>
        <table class="table">
          <thead>
            <tr>
                <slot name="thead"></slot>
                <th>{t 'Action'}</th>
            </tr>
          </thead>
          <tbody p-if="isset($collection)">
            <tr p-foreach="$collection as $item" :lm-crud-item="$item['id']">
                <slot :item="$item"></slot>
                <td class="text-end">
                    <x-btn-edit type="button" lm-crud-edit></x-btn-edit>
                    <x-btn-delete type="button" lm-crud-delete></x-btn-delete>
                </td>
            </tr>
          </tbody>
        </table>
    </div>
    
    <x-modal lm-crud-modal>
        <tpl slot="footer">
            <x-btn-save lm-crud-submit></x-btn-save>
        </tpl>
    </x-modal>
</div>

<script>
    let {{ $id }} = new Crud( $('#{{ $id }}'), '{{ route("admin/$resource", $params) }}' );
    {{ $id }}.init({{ !isset($collection) ? 1 : 0 }});
</script>