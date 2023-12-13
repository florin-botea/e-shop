<?php

namespace App\Models\Setting;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class Store extends Model
{
    protected $fillable = [
        'name'
    ];
    
    public function validator($data = [], $id = 0)// todo typehint return
    {
        return Validator::make($data, [
            'name' => 'required|min:3',
        ]);
    }
    
    public function settings()
    {
        return $this->hasOne(\App\Models\Setting::class);
    }
    
    public function saveSettings($code, array $data)
    {
        foreach ($data as $key => $value) {
            $isJson = 0;
            if (!is_scalar($value) && !is_null($value)) {
                $value = json_encode($value);
                $isJson = 1;
            }
            
            $this->settings()->updateOrCreate([
                'code' => $code,
                'key' => $key
            ], [
                'value' => $value,
                'is_json' => $isJson
            ]);
        }
    }
    
    public function getSettings($code) 
    {
        $settings = \DB::table('settings')
        ->where('store_id', $this->id)
        ->where('code', $code)
        ->get();
        
        $return = [];
        foreach ($settings as $setting) {
            $return[$setting->key] = $setting->is_json ? json_decode($setting->value, true) : $setting->value;
        }

        return $return;
    }
}
