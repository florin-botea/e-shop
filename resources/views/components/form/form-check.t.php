<div class="form-check" :class="['form-switch' => $type == 'switch', 'form-check-inline' => $inline]">
  <input type="hidden" :name="$name" value="">
  <input class="form-check-input" :type="$type == 'switch' ? 'checkbox' : $type" :id="$id" :value="$value" p-bind="$this->attrs()">
  <label class="form-check-label" :for="$id">
      <slot name="label">{{ $label }}</slot>
  </label>
</div>

<?php return new class 
{
    protected array $props = [
        'value' => 1,
        'type' => 'checkbox',
    ];
    
    public function data($data): array
    {
        $data['id'] = $data['id'] ?? 'f-' . uniqid();
        
        return $data;
    }
};