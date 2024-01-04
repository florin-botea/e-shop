<div class="input-group mb-1" p-foreach="$LANGUAGES as $language">
  <span class="input-group-text">{{ $language->name }}</span>
  <input type="hidden" :name="$this->name($language->id, 'language_id')" :value="$language->id">
  <input type="text" :name="$this->name($language->id, $name)" :value="$value[$language->id][$name] ?? null" class="form-control">
</div>

<?php
return new class
{
    protected array $props = [
        'name' => 'name',
        'value' => [],
    ];

    private function name($language_id, $key)
    {
        $id = $this->props['value'][$language_id]['id'] ?? 'new-' . $language_id;
        return "languages[$id][$key]";
    }
};