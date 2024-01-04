<div class="row">
    <x-form-check :name="$name . '[nullable]'" class="col-sm-12" label="{t 'Nullable'}" :checked="$nullable"></x-form-check>
    <x-form-group :name="$name . '[prefix]'" class="col-sm-12" label="{t 'Config prefix'}" :value="$prefix"></x-form-group>
</div>