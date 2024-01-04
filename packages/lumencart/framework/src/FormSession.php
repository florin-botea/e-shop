<?php

namespace LumenCart;

use Illuminate\Database\Eloquent\Model as BaseModel;
use Illuminate\Support\Facades\Validator;

class FormSession
{
    private $form_id;
    private $model;
    private $collection;
  
    public static function pull($form_id, $array = false)
    {
        $relationships = (array)session()->pull($form_id, []);
 
        foreach ($relationships as $key => $collection) {
            foreach ($collection as $item) {
                if (strpos($item->id, '0-') === 0) {
                    unset($item->id);
                    $item->incrementing = true;
                }
            }
        }
        
        if ($array) {
            return json_decode(json_encode($relationships), true);
        }
        
        return $relationships;
    }  
    
    public function __construct($form_id, $model, $where = []) 
    {
        $this->form_id = $form_id;
        $this->model = app()->model($model);
       
        $collection = session()->get($form_id);
        if (! $collection) {
            $collection = $this->model;
            foreach ($where as $key => $value) {
                $collection = $collection->where($key, $value);
            }
            $collection = $collection->get();
        
            session()->put($this->form_id, $collection);
        }
        
        $this->collection = $collection;
    }
    
    public function find($id) 
    {
        return $this->collection->where('id', $id)->first();
    }
    
    public function updateOrCreate($where, $update) 
    {
        $collection = $this->collection;
        foreach ($where as $key => $value) {
            $collection = $collection->where($key, $value);
        }
        
        $item = $collection->first();
        if (! $item) {
            $item = $this->model->new();
            $item->incrementing = false;
            $item->id = '0-' . uniqid();
            $this->collection->push($item);
        }
        
        $item->fill(array_merge($where, $update));
        
        return $item;
    }
    
    public function delete($id) {
        $this->collection = $this->collection->filter(fn($item) => $item->id != $id);
    }

    public function __call($m, $args) {
        if (method_exists($this->collection, $m)) {
            return $this->collection->{$m}(...$args);
        }
        
        return $this->model->{$m}(...$args);
    }
    
    public function __destruct() 
    {
        session()->put($this->form_id, $this->collection);
    }
}