<a p-if="$href" :href="$href" data-toggle="tooltip" title="{{ trans('create') }}" class="btn btn-primary{{ $class ? ' '.$class : '' }}" p-bind="$this->attrs()">
  <i class="fa fa-plus"></i>
</a>
<button p-else data-toggle="tooltip" title="{{ trans('create') }}" class="btn btn-primary{{ $class ? ' '.$class : '' }}" p-bind="$this->attrs()">
  <i class="fa fa-plus"></i>
  <div class="spinner-border spinner-border-sm text-primary mx-2" role="status"></div>
</button>

<?php return new class {
    protected array $props = [
        'route' => null,
        'href' => null,
    ];
    
    public function data($data): array 
    {
        if (isset($data['route'])) {
            $data['href'] = route('admin/' . $data['route']);
        }
        
        return $data;
    }
};