<button type="submit" :form="$form" data-toggle="tooltip" title="{{ trans('save') }}" class="btn btn-primary{{ $class ? ' '.$class : '' }}" p-bind="$this->attrs()">
  <i class="fa fa-save"></i>
  <div class="spinner-border spinner-border-sm text-primary mx-2" role="status"></div>
</button>

<?php return new class {
    protected array $props = [
        'form' => null,
    ];
};