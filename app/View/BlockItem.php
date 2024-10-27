<?php

namespace App\View;

use App\Models\System\BlockLayout as Block;

class BlockItem
{
  private $code;
  private $data;
  private $slots;
  
  public function __construct($code, $data, $slots)
  {
    $this->code = $code;
    $this->data = $data;
    $this->slots = $slots;
  }
  
  public function render()
  {
    $template = app('htme')->make($this->code);
    $template->setData($this->data);
    
    foreach ($this->slots as $pos => $slots) {
      foreach ($slots as $item) {
        $code = $item['code'];
        $data = $item['data'];
        $slots = $item['slots'] ?? [];
        $template->addSlot($pos, new BlockItem($code, $data, $slots));
      }
    }
    
    $template->template();
  }
}