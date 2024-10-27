<?php

namespace App\View;

use App\Models\System\BlockLanguage;

abstract class Template
{
    public $multilingual = [];

    private $data;
    private $slot;

    public function setData($data) {
        $this->data = $data;
    }

    public function addSlot($pos, $slot) {
        $code = $slot['code'];
        $data = $slot['data'];
        $slots = $slot['slots'];

        $slot = app('htme')->make($code, $data, $slots);

        $this->slots[$pos][] = $slot;
    }

    public function slots($pos = 'default') {
        foreach (($this->slots[$pos] ?? []) as $item) {
            echo $item->render();
        }
    }

    public function render() {}

    public function save(&$model, $request) {
        $key = $this->data['model'] ?? null;

        if (empty($key)) {
            return;
        }

        if (strpos($key, '.')) {
            dd('todo: relational save switch based on rel type');
        }

        $model->$key = $request->get($key);
    }

    protected function view($file) {
        extract($this->data);

        require($file);
    }

    public function trans($str) {
        [$_, $module_code, $block_code, $code] = explode('//', $str);
        // todo
        $val = BlockLanguage::where('module', $module_code)
        ->where('block', $block_code)
        ->where('code', $code)
        ->toBase()
        ->select('text', 'lang')
        ->get()
        ->pluck('text', 'lang')
        ->toArray();
        
        echo $val['ro'];
    }
}