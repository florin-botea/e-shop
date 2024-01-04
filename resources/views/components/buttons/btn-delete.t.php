<button data-toggle="tooltip" title="{{ trans('delete') }}" class="btn btn-danger {{ $class ? ' '.$class : '' }}" p-bind="$this->attrs()">
  <i class="fa fa-trash"></i>
  <div class="spinner-border spinner-border-sm text-danger mx-2" role="status"></div>
</button>