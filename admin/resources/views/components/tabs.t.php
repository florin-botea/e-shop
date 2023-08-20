<div :class="$class1">
    <ul class="nav nav-tabs" :class="$class2" :id="$id2" role="tablist">
      <slot name="tabs">
        <li p-foreach="$items as $val => $label" class="nav-item" role="presentation">
          <button class="nav-link" :class="['active' => $val == $active]" :id="$val.'-tab'" data-bs-toggle="tab" :data-bs-target="'#'.$val" type="button" role="tab" :aria-controls="$val" aria-selected="true">{{ $label }}</button>
        </li>
      </slot>
    </ul>
    <div class="tab-content">
      <tpl p-if="$items">
        <div p-foreach="$items as $k => $tmp" class="tab-pane" :class="[$class, 'show active' => $active == $k]" :id="$k" role="tabpanel" :aria-labelledby="$k.'-tab'">
          {% $this->renderSlots($k, []) %}
        </div>
      </tpl>
      <tpl p-else p-foreach="$this->slots() as $k => $slot">
        <div p-if="$k != 'tabs'" class="tab-pane" :class="[$class, 'show active' => $active == $k]" :id="$k" role="tabpanel" :aria-labelledby="$k.'-tab'">
          {% $this->renderSlots($k, []) %}
        </div>
      </tpl>
    </div>
</div>

<?php return new class {

    public function data($data): array
    {
        $class1 = isset($data['vertical']) ? 'd-flex align-items-start' : '';
        $class2 = $data['class'] ?? '';
        $class2 = trim($class2 . ' ' . isset($data['vertical']) ? 'flex-column' : '');
        $id2 = $data['id'] ?? '';
        $items = $data['items'] ?? [];
        $active = $data['value'] ?? array_keys($items)[0] ?? null;
        $class10 = isset($data['fade']) ? 'fade' : '';

        return compact(
            'class1',
            'class2',
            'id2',
            'items',
            'active',
            'class10'
        );
    }
};