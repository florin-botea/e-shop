<?php

namespace App\View;

use App\Models\System\BlockLayout as Block;

class BlockLayout implements \Stringable
{
    private $code;
    private $model;

    private $block;
    private $request;

    public function __construct(string $code, $model = null) {
        $this->code = $code;
        $this->model = $model;
    }

    /**
    * Will return a new php-template instance of composed view
    */
    public function getView() {
        $templateString = $this->buildBlockLayoutString();

        $code = str_replace('.', '@', $this->code);
        $file = resource_path('views/_blocks/' . $code . '.t.php');
        file_put_contents($file, $templateString);

        $data['MODEL'] = $this->model;

        return view('_blocks/' . $code, $data);
    }

    protected function buildBlockLayoutString() {
        $block = $this->block();
        $items = $block->data;

        ob_start();
        foreach ($items as $itemData) {
            $code = $itemData['code'];
            $data = $itemData['data'];
            $slots = $itemData['slots'] ?? [];
            $item = app('htme')->make($code, $data, $slots);

            $item->render();
        }
        
        $render = ob_get_contents();
        ob_clean();
        
        dump($render);
        return $render;
    }

    protected function block() {
        if (!$this->block) {
            $this->block = Block::where('code', $this->code)->first();
        }

        return $this->block;
    }

    public function input($request) {
        $this->request = $request;

        return $this;
    }

    public function validate() {
        $block = $this->block();

        $recursive = function($item) use (&$recursive) {
            $instance = app('htme')->make($item['code'], $item['data']);

            // todo validate

            foreach (($item['slots'] ?? []) as $pos => $slots) {
                foreach ($slots as $slot) {
                    $recursive($slot);
                }
            }
        };

        foreach ($block->data as $item) {
            $recursive($item);
        }

        return $this;
    }
    
    public function save()
    {
        // todo optimizam cu validate, add type pe component
        $block = $this->block();

        $recursive = function($item) use (&$recursive) {
            $instance = app('htme')->make($item['code'], $item['data']);

            $instance->save($this->model, $this->request);

            foreach (($item['slots'] ?? []) as $pos => $slots) {
                foreach ($slots as $slot) {
                    $recursive($slot);
                }
            }
        };

        foreach ($block->data as $item) {
            $recursive($item);
        }
        
        $this->model->save();

        return $this->model;
    }

    public function __toString() {
        return (string)$this->getView();
    }
}