<?php

namespace App\Models\Localisation;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class Language extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'name',
        'code',
    ];
    
    public function validator($data = [], $id = 0)// todo typehint return
    {
        return Validator::make($data, [
            'name' => 'required|min:3',
            'code' => 'required|min:2|unique:languages,code,' . $id . ',id',
        ]);
    }
}
