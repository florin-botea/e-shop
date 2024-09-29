<?php

namespace App\View;

use PhpTemplates\PhpTemplates;

class Component
{
    private $list = [];
    
    public function __construct()
    {
        
    }
    
    public function setupForm(string $type, array $settings = [])
    {
        $phpt = app()->make(PhpTemplates::class);
        $phpt->share(app('view')->getShared());

        $view = $this->makeView($type, $settings, 'setup-form');
        
        return $phpt->fromRaw($view, ['_model' => $settings]);
    }
    
    public function display()
    {
//         if (ext of this file is .t.php) {
//             phpt fromFile
//         } else {
//             template load ob
//         }
//         
        // if is static return viewraw de include cu setare
        // else return de string apelare componenta cu setari
    }
    
    public function manage(string $type, array $settings = [])
    {
        $phpt = app()->make(PhpTemplates::class);
        $phpt->share(app('view')->getShared());

        $view = $this->makeView($type, $settings, 'manage');
        
        return $phpt->fromRaw($view, ['_model' => $settings]);        
    }
    
    public function validate()
    {
        
    }
    
    private function makeView($type, $settings, $mode)
    {
        $file = $this->solvePath($type, $mode);
        
        ob_start();
        include($file);
        extract($settings);
        $phpt = ob_get_contents();
        ob_end_clean();
        
        return $phpt;
    }
    
    private function solvePath($type, $mode)
    {// todo: theme aware
        return resource_path('components/'. $type .'/'. $mode .'.php');
    }
}