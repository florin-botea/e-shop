<?php

namespace App\View;

class FormGroup
{
  private $data;
  
  public function setData($data)
  {
    $this->data = $data;
  }
  
  public function template()
  {
    ?>
    <div class="form-group">
      <?php $this->slots('default'); ?>
    </div>
    <?php
  }
}