<button type="submit" :form="$form" data-toggle="tooltip" title="{{ trans('save') }}" class="btn btn-primary" p-bind="$this->attrs()">
  <i class="fa fa-save"></i>
</button>

<?php return new class {
    protected array $props = [
        'form' => null,
    ];
};