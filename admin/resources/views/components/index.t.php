{% $id = 'index_' . uniqid() %}
<div :id="$id">
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
                    <x-btn-edit class="lm-index-edit" :href="$this->urlEdit($resource, $item['id'])"></x-btn-edit>
                    <x-btn-delete type="button" class="lm-index-delete"></x-btn-delete>
                </td>
            </tr>
          </tbody>
        </table>
    </div>
</div>

<script>
    let {{ $id }} = new Index($('#{{ $id }}'), '{{ $resource }}', {{ json_encode($params) }});
    {{ $id }}.init({{ !isset($collection) ? 1 : 0 }});
</script>

<?php return new class {
    public function urlEdit($resource, $id) {
        $part = explode('/', $resource);
        $part = end($part) . '_id';
        return route($resource . '/edit', [$part => $id]);
    }
};