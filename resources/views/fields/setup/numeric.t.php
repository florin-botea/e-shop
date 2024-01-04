<div class="row">
    <x-form-group :name="$name . '[min]'" class="col-sm-6" label="{t 'Min'}" type="number" :value="$min"></x-form-group>
    <x-form-group :name="$name . '[max]'" class="col-sm-6" label="{t 'Max'}" type="number" :value="$max"></x-form-group>
</div>