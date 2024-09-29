<?php

namespace App\View\Pieces;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting\Store;

class Startup
{
    private $items;
    
    public function __construct($items)
    {
        $this->items = $items;
    }
    
    public function form()
    {
        return view('pieces/startup/form', ['items' => $this->items]);
    }
}