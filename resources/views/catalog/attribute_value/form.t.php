<x-form :action="$action">
  <div class="row mb-3">
      <label class="col-12">{{ $label }}</label>
      <div :class="[$unit_field ? 'col-8' : 'col-12']">
          {!! $value_field !!}
      </div>
      <div p-if="$unit_field" class="col-4">
          {!! $unit_field !!}
      </div>
  </div><button>x</button>
</x-form>