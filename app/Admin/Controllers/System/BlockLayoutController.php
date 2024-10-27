<?php

namespace App\Admin\Controllers\System;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting\Store;
use App\Models\System\BlockLayout;
use App\View\BlockLayout as ViewBlockLayout;
use App\Models\System\BlockLanguage;

/**
* This route handles adding layouts to be consumed by controllers.
* A layout have an unique code, which can't be edited after save.
*/
class BlockLayoutController extends Controller
{
    protected $request;

    public function __construct(Request $request) {
        $this->request = $request;
    }

    public function index() {
        $data['url_block_layout_create'] = route('admin/system/block_layout/create');
        $data['collection'] = [];

        return view('system/block_layout/index', $data);
    }

    public function create() {
        $data['form_block_layout']['action'] = route('admin/system/block_layout');
        $data['form_block_layout']['method'] = 'POST';

        $models = get_dir_classes(base_path('app/Models'), 'App\\Models'); // todo from db

        $data['model_options'] = array_map(function($model) {
            return [
                'label' => $model,
                'value' => $model,
            ];
        }, $models);

        return view('system/block_layout/form', $data);
    }

    public function store() {
        $create = $this->request->all();
        $create['data'] = json_decode($create['data'], true);
        BlockLayout::where('code', $create['code'])->delete();

        BlockLayout::create($create);
    }

    public function edit($block_layout_id) {
        $block_layout = BlockLayout::find($block_layout_id);
        $data = $block_layout->data;
        $recursive = function($item) use (&$recursive) {
            foreach ($item['data'] as $key => $val) {
                if (is_string($val) && strpos($val, 'htme//') === 0) {
                    [$_, $module_code, $block_code, $code] = explode('//', $val);
                    $val = BlockLanguage::where('module', $module_code)
                    ->where('block', $block_code)
                    ->where('code', $code)
                    ->toBase()
                    ->select('text', 'lang')
                    ->get()
                    ->pluck('text', 'lang')
                    ->toArray();
                    
                    $item['data'][$key] = $val;
                }
            }
            
            foreach (($item['slots'] ?? []) as $pos => $slots) {
                foreach ($slots as $i => $slot) {
                    $item['slots'][$pos][$i] = $recursive($slot);
                }
            }
            
            return $item;
        };
        
        foreach ($data as $i => $item) {
            $data[$i] = $recursive($item);
        }
        
        $block_layout->data = $data;

        $data['MODEL'] = $block_layout;
        $data['form_block_layout']['action'] = route('admin/system/block_layout', ['block_layout_id' => $block_layout_id, '_method' => 'PUT']);

        $models = get_dir_classes(base_path('app/Models'), 'App\\Models'); // todo from db

        $data['model_options'] = array_map(function($model) {
            return [
                'label' => $model,
                'value' => $model,
            ];
        }, $models);

        return view('system/block_layout/form', $data);
    }

    public function update($block_layout_id) {
        $block_layout = BlockLayout::find($block_layout_id);
        
        $module_code = $block_layout->module ?? 'default'; // todo
        $block_code = $block_layout->code;
        
        BlockLanguage::where('module', $module_code)
        ->where('block', $block_code)
        ->delete();
        
        $update = $this->request->all();
        $data = json_decode($update['data'], true);

        $recursive = function($item) use (&$recursive, $module_code, $block_code) {
            $instance = app('htme')->make($item['code'], $item['data']);

            foreach ($instance->multilingual as $key) {
                $translates = $item['data'][$key] ?? [];
                if (empty($translates)) continue;
                
                $langs = array_keys($translates);
                $translates = array_values($translates);
                
                #region [fallback on first, in case of no main translate]
                if (empty($translates[0])) {
                    $temp = array_filter($translates, 'strlen');
                    $temp = reset($temp);
                    if (strlen($temp) === 0) continue; # nothing to fallback on
                    
                    $translates[0] = $temp;
                }
                #endregion
                
                $hash = md5($translates[0]);
                
                foreach ($langs as $i => $lang) {
                    if (strlen($translates[$i]) === 0) continue;
                    
                    BlockLanguage::create([
                        'module' => $module_code,
                        'block' => $block_code,
                        'code' => $hash,
                        'lang' => $lang,
                        'text' => $translates[$i]
                    ]);
                }
                
                $item['data'][$key] = 'htme//' . $module_code . '//' . $block_code . '//' . $hash;
            }
            
            foreach (($item['slots'] ?? []) as $pos => $slots) {
                foreach ($slots as $i => $slot) {
                    $item['slots'][$pos][$i] = $recursive($slot);
                }
            }
            
            return $item;
        };
        
        foreach ($data as $i => $item) {
            $data[$i] = $recursive($item);
        }
        
        $update['data'] = $data;

        $block_layout->update($update);
    }

    protected function form() {}
}