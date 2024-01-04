<x-form :action="$action">
    <x-form-group p-model="name" />
    <x-form-group type="multilang" p-model="label" />
    <x-form-group type="multilang" p-model="helper" />
    <x-form-group type="multilang" p-model="mention" />
    <x-form-group type="multilang" p-model="placeholder" />
    <tpl is="fields/field_select" p-model="field" prefix="config" :field_config="$field_config" />
    <x-form-group p-model="sort_order" type="number" />
    <button>x</button>
</x-form>