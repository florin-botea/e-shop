<form :action="$action" :method="$method" encrypt="multipart/form-data" p-bind="$this->attrs()" :class="$class">
  <slot></slot>
</form>

<?php return new class {
    protected array $props = [
        'class' => null,
        'method' => 'POST',
        'action' => '',
    ];
};