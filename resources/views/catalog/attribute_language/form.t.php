<x-form :action="$action">
    <x-form-group type="select" p-model="language_id" :options="$language_options"></x-form-group>
    <x-form-group p-model="name"></x-form-group>
</x-form>