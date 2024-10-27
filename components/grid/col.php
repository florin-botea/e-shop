<?php

use App\View\Template;

return fn() => new class extends Template
{
    public function render()
    {
        $file = resource_path('views/htme/components/grid/col.php');
        
        $this->view($file);
    }
    
    // validate incoming input
    public function validate() {
        
    }
    
    // handle incoming input
    public function onInput($data) {
        
    }
};