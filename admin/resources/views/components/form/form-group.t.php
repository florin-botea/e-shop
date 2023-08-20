<div class="form-group mb-3" :class="[$class, 'row' => $inline]">
  <slot name="label">
    <label :for="$id" class="form-label" :class="['col-sm-2 col-form-label' => $inline, $size ? 'col-form-label-'.$size : '']">{{ $label }}</label>
  </slot>
  <div :class="['col-sm-10' => $inline]">
      <div :class="['input-group' => $isInputGroup, $size && $isInputGroup ? 'input-group-'. $size : '']">
        <slot name="prepend">
          <span class="input-group-text" p-if="$prepend">{{ $prepend }}</span>
        </slot>
        <slot p-bind="['attrs' => $this->attrs()]">
          <tpl is="components/form/input" p-bind="$this->attrs()"></tpl>
        </slot>
        <slot name="append">
          <span class="input-group-text" p-if="$append">{{ $append }}</span>
        </slot>
      </div>
      <span class="error-bag">
        <div p-if="$error" class="text-danger">{{ $error }}</div>
      </span>
  </div>
</div>

<?php 
return new class 
{
    private $inputs = [];
    
    public function data($data): array
    {
        $data['id'] = $data['id'] ?? $data['name'] ?? 'f-' . uniqid();
        $data['isInputGroup'] = $data['prepend'] || $data['append'] || $this->slots('prepend') || $this->slots('append');
        
        return $data;
    }
    
    private function getInput($data) {
        $errors = $this->shared->errors;
        if (strpos($data['name'], '.')) {
            $parts = explode('.', $data['name']);
            $r = $parts[0];
            unset($parts[0]);
            $k = $r . '.' . implode('.', $parts);
            $label = $data['label'] ?? ($end = end($parts));
            $name = $r . '[' . implode('][', $parts) . ']';
        } else {
            $k = $data['name'];
            $end = $data['name'];
            $label = $data['label'] ?? $data['name'];
            $name = $data['name'];                
        }
        $inp['error'] = $errors->first($k);
        $inp['name'] = $name;
        $value = $data['value'] ?? '';
        if (isset($data['model'])) {
            $value = data_get($data['model'], $k);
        }
        $inp['label'] = trans($label);
        $inp['value'] = old($name, $value) ?? '';
        $inp['id'] = $data['id'] ?? 'input-'.$end;
        $inp = array_merge($data, $inp);
        unset($inp['model']);
        return $inp;
    }
    
    private function getMultilangInputs($data) {
        $result = [];
        $errors = $this->shared->errors;
        foreach ($this->shared->languages as $lang) {
            $inp = [];
            if (strpos($data['name'], '.')) {
                $parts = explode('.', $data['name']);
                $r = $parts[0];
                $parts[0] = $lang['value'];
                $k = $r . '.' . implode('.', $parts);
                $label = $data['label'] ?? ($end = end($parts));
                $name = $r . '[' . implode('][', $parts) . ']';
            } else {
                $k = $lang['value'] . '.' . $data['name'];
                $end = $data['name'];
                $label = $data['label'] ?? $data['name'];
                $name = $lang['value'] . '[' . $data['name'] . ']';                
            }
            $inp['error'] = $errors->first($k);
            $inp['name'] = $name;
            $value = '';
            if (isset($data['model'])) {
                $value = data_get($data['model'], $k);
            }
            $inp['label'] = trans($label);
            $inp['value'] = old($name, $value) ?? '';
            $inp['id'] = $data['id'] ?? 'input-'.$end . '-' . $lang['value'];
            $inp = array_merge($data, $inp);
            unset($inp['model']);
            unset($inp['multilang']);
            $result[$lang['value']] = $inp;
        }
        return $result;
        if (!array_key_exists('error', $data) && $errors) {
            $data['error'] = $errors->first($name);
        }
        $value = null;
        if (isset($data['model'])) {
            $value = data_get($data['model'], $name);
        }
        $value = old($name, $value) ?? '';
        if (!isset($data['id'])) {
            $data['id'] = 'input-'.$name;
        }
        if (!isset($data['label'])) {
            $data['label'] = trans($name);
        }
                
        
        if (!strpos($name, '.')) {
            return array_map(fn($l) => $l['value'] .'.'. $name, $this->registry->shared->languages);
        }
        $name = explode('.', $name);
        $root = array_shift($name);
        return array_map(fn($l) => $root . ".{$l['value']}." . implode('.', $name), $this->shared->languages);
    }
};// pl