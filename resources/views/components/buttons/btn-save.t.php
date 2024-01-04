<button :type="$type" data-toggle="tooltip" title="{{ trans('save') }}" class="btn btn-primary{{ $class ? ' '.$class : '' }}" p-bind="[...$this->attrs(), 'form' => $form]">
  <i class="fa fa-save"></i>
  <div class="spinner-border spinner-border-sm text-primary mx-2" role="status"></div>
</button>

<?php return new class {
    protected array $props = [
        'form' => null,
        'type' => 'submit' // todo all same add this line, also formstuff
    ];
};