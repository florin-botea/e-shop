<select p-if="$type == 'select'" :class="$class" p-bind="$this->attrs()">
    <option p-if="$blank" value="">{{ $blank }}</option>
    <option p-foreach="$options ?? [] as $option" p-bind="array_diff_key($option, ['label'=>1])" p-selected="$option['value'] == $value">{{ $option['label'] }}</option>
</select>
<textarea p-elseif="$type == 'textarea'" :class="$class" p-bind="$this->attrs()">{{ $value }}</textarea>
<input p-else :class="$class" :type="$type" :value="$value" p-bind="$this->attrs()">

<?php
return new class
{
    protected array $props = [
        'class' => '',
        'type' => 'text',
        'value' => '',
        'blank' => false,
        'options' => [],
        'size' => '',
    ];

    public function data($data): array
    {
        if (empty($data['type'])) {
            $data['type'] = 'text';
        }
        if ($data['type'] == 'switch') {
            $data['type'] = 'checkbox';
        }

        $class = [
            'select' => 'form-select',
            'color' => 'form-control-color',
            'radio' => 'form-check-input',
            'checkbox' => 'form-check-input',
            'range' => 'form-range',
        ][$data['type']] ?? 'form-control';

        if (!empty($data['class'])) {
            $class .= ' '. $data['class'];
        }

        if (!empty($data['size'])) {
            $class .= 'form-control-'. $data['size'];
        }

        $data['class'] = $class;

        return $data;
    }
};