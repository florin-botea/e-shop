<div class="field-select-wrapper">
  <x-form-group type="select" p-bind="$this->scope->all()" class="field-select" :prefix="$prefix"></x-form-group>
  <div class="field-config">{!! $field_config !!}</div>
</div>

<?php return new class {
    public function data($data): array
    {
        if (!isset($data['options'])) {
            $data['options'] = app('fields')->toSelectOptions();
        }
        
        return $data;
    }
};