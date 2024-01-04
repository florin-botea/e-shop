<div class="form-group mb-3" :class="[$class, 'row' => $inline]">
    <slot name="label">
        <label :for="$id" class="form-label" :class="['col-sm-2 col-form-label' => $inline, $size ? 'col-form-label-'.$size : '']">{{ $label }}</label>
    </slot>
    <div p-if="$type != 'multilang'" :class="['col-sm-10' => $inline, 'input-group' => $isInputGroup, $size && $isInputGroup ? 'input-group-'. $size : '']">
        <slot name="prepend">
            <span class="input-group-text" p-if="$prepend">{{ $prepend }}</span>
        </slot>
        <slot p-bind="['attrs' => $this->attrs()]">
            <tpl p-if="$multilang" p-foreach="$LANGUAGES as $lang" is="components/form/input" p-bind="$this->attrs()" :class="'input-lang lang-'. $lang->id"></tpl>
            <tpl p-else is="components/form/input" p-bind="$this->attrs()"></tpl>
        </slot>
        <slot name="append">
            <span class="input-group-text" p-if="$append">{{ $append }}</span>
        </slot>
        <span class="error-bag">
            <div p-if="$error" class="text-danger">{{ $error }}</div>
        </span>
    </div>
    <tpl is="components/form/input-multilang" p-else p-bind="$this->scope->all()" />
</div>

<?php
return new class
{
    public function data($data): array
    {
        $data['id'] = $data['id'] ?? $data['name'] ?? 'f-' . uniqid();
        $data['isInputGroup'] = !empty($data['prepend']) || !empty($data['append']) || $this->slots('prepend') || $this->slots('append');

        return $data;
    }
};
