<form :action="$action" :method="$method" encrypt="multipart/form-data" p-bind="$this->attrs()" :class="$class">
  <slot></slot>
</form>

<?php return new class {
    protected array $props = [
        'class' => null,
        'method' => 'POST',
        'action' => '',
    ];
    
    public function data($data): array
    {
        if (!isset($data['action'])) 
        {
            $action = request()->path();
            $parts = explode('/', $action);
            $last = array_pop($parts);
            
            $action = implode('/', $parts);
            if ($last == 'edit') {
                $action .= '?_method=PUT';
            }
            $data['action'] = '/' . $action;
        }
        
        return $data;
    }
};