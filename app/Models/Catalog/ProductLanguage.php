<?php

namespace App\Models\Catalog;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use LumenCart\Model;
use LumenCart\Traits\IsLanguage;

class ProductLanguage extends Model
{
    use IsLanguage;
    // todo table name must be singular
    protected $fillable = [
        'product_id',
        'language_id',
        'name',
    ];
}
