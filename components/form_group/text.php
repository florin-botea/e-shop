<?php

use App\View\Template;

return fn() => new class extends Template
{
    public $multilingual = [
        'label',
        'placeholder',
    ];
    
    public function render()
    {
        $file = resource_path('views/htme/components/form_group/text.php');
        
        $this->view($file);
    }
    
    // validate incoming input
    public function validate() {
        
    }
    
    // handle incoming input
    public function onInput() {
        
    }
};