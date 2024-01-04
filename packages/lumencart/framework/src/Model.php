<?php

namespace LumenCart;

use Illuminate\Database\Eloquent\Model as BaseModel;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Relations\Relation;

class Model extends BaseModel
{
    protected $validationRules = [];
    protected $validationMessages = [];
    
    public function validator($data = [], $id = 0)
    {
        return Validator::make($data, $this->validationRules, $this->validationMessages);
    }
    
    public function createWithRelationships($data)
    {
        $model = $this->create($data);
        
        $this->dataRelation($model, $data, function($rel, $data) {
            foreach ($data as $id => $val) {
                # keys must be relation ids, even if is one to one
                $rel->create($val)
                ->updateWithRelationships($val);
                // todo: test if multi query
            }            
        });
        
        return $model;
    }
    
    public function updateWithRelationships($data)
    {
        $this->update($data);
        $model = $this;
        
        $this->dataRelation($model, $data, function($rel, $data) {
            # keys must be relation ids, even if is one to one
            // delete missing
            (clone $rel)->whereNotIn('id', array_keys($data))->delete();
            // update or create
            foreach ($data as $id => $val) {
                $record = (clone $rel)->find($id);
                if ($record) {
                    $record->updateWithRelationships($val);
                } else {
                    $rel->create($val)
                    ->updateWithRelationships($val);
                    // todo test if multi query
                }
            }
        });
        
        return $model;
    }
    
    /**
     * Find possible relation in data key and pass them along with value as callback params
     */
    protected function dataRelation($model, $data, $callback)
    {
        $fillable = $this->getFillable();
        $foreign_key = get_class($this);
        $foreign_key = explode('\\', $foreign_key);
        $foreign_key = Str::snake(end($foreign_key)) . '_id';
        foreach ($data as $key => $val) {
            // not fillable, nor unexisting method
            if (!is_array($val) || in_array($key, $fillable) || !method_exists($this, $key)) {
                continue;
            }
            
            try {
                $rel = $model->{$key}();
            } catch(\Exception $e) {
                continue;
            }
            
            if ($rel instanceof Relation) {
                $val = array_map(function($val) use ($model, $foreign_key) {
                    $val[$foreign_key] = $model->id;
                    return $val;
                }, $val);
                $callback($rel, $val);
            }
        }        
    }
    
//     public static function boot(): void
//     {
//         parent::boot();
//         
//         static::creating(function($model) {
//             
//         });
//     }
}