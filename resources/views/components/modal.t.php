<div class="modal" :class="[$class, $fade ? 'fade' : '']" :id="$id" p-bind="array_merge($this->attrs(), $_attrs)" tabindex="-1" :aria-labelledby="$id" aria-hidden="true">
  <div class="modal-dialog" :class="['modal-dialog-scrollable' => $scrollable, 'modal-dialog-centered' => $centered, $size ? 'modal-'.$size : '']">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"><slot name="title">{{ $title }}</slot></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <slot></slot>
      </div>
      <div p-if="$this->slots('footer')" class="modal-footer">
        <slot name="footer"></slot>
      </div>
    </div>
  </div>
</div>

<?php 
return new class {
    protected array $props = [
        'id' => null,
        'title' => '',
        'class' => '',
        'fade' => false,
        'static' => null,
        'esc' => null,
        'scrollable' => null,
        'centered' => null,
        'size' => null,
    ];
    
    public function data($data): array 
    {
        if (empty($data['id'])) {
            $data['id'] = 'modal-'.uniqid();
        }
        
        $data['_attrs'] = [
            'data-bs-keyboard' => empty($data['esc']) ? 'false' : 'true'
        ];
        if (!empty($data['static'])) {
            $data['_attrs']['data-bs-backdrop'] = 'static';
        }
 
        return $data;
    }
};