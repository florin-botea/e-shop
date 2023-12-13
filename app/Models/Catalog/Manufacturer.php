<?php

namespace App\Models\Catalog;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Manufacturer extends Model
{
    protected $fillable = [
        'name',
        'image_id',
    ];
    
    public function description()
    {
        return $this->hasOne(ManufacturerDescription::class);
    }
    
    public function descriptions() 
    {
        return $this->hasMany(ManufacturerDescription::class);
    }
    
    public function validator($data = [], $id = 0)
    {
        return Validator::make($data, [
            'name' => 'required|min:3|unique:manufacturers,name,' . $id . ',id',
        ]);
    }
    
    public function scopeWithDescription($query)
    {
        return $query->join('manufacturer_descriptions as md', function($j) {
            $j->on('md.manufacturer_id', '=', 'manufacturers.id');
            $j->on('md.language_id', '=', \DB::raw(1));
        });
    }
}
