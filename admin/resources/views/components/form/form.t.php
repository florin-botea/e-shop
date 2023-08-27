<form :action="$action" :method="in_array(strtolower($method), ['post', 'put']) ? 'POST' : 'GET'" encrypt="multipart/form-data" p-bind="$this->attrs()" :class="$class">
  <input name="_method" :value="$method" hidden>
  <slot></slot>
</form>

<?php return new class {
    protected array $props = [
        'class' => null,
        'method' => 'POST',
        'action' => '',
    ];
};