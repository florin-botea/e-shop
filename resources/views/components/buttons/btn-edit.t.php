<a p-if="$href" :href="$href" data-toggle="tooltip" title="{{ trans('edit') }}" class="btn btn-success{{ $class ? ' '.$class : '' }}" p-bind="$this->attrs()">
  <i class="fa fa-edit"></i>
</a>
<button p-else data-toggle="tooltip" title="{{ trans('edit') }}" class="btn btn-success{{ $class ? ' '.$class : '' }}" p-bind="$this->attrs()">
  <i class="fa fa-edit"></i>
  <div class="spinner-border spinner-border-sm text-success mx-2" role="status"></div>
</button>