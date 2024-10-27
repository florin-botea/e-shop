<?php

namespace App\View;

use App\Models\System\BlockLayout as Block;

class Htme
{
  private $components = [];
  
  public function make($code, $data, $slots = [])
  {
    $this->components['default:form_group_text'] = base_path('components/form_group/text.php');
    $this->components['default:row'] = base_path('components/grid/row.php');
    $this->components['default:col'] = base_path('components/grid/col.php');
    $file = $this->components[$code];

    $class = require($file);
    
    $instance = $class(1);
    $instance->setData($data);
    foreach ($slots as $pos => $slots) {
        foreach ($slots as $slot) {
            $instance->addSlot($pos, $slot);
        }
    }

    return $instance;
  }
}