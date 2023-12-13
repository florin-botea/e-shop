<?php

namespace App\Models\Localisation;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use LumenCart\Model;

class LengthClass extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'name',
        'value'
    ];
}
