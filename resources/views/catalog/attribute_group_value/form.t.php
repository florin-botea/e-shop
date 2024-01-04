<x-form :action="$action">
  <x-form-group p-model="attribute_id" type="select" :options="$attribute_options"></x-form-group>
  <x-form-group p-model="sort_order" type="number"></x-form-group>
</x-form>