<li class="nav-item" role="presentation">
  <button class="nav-link" :class="['active' => $active]" :id="$value.'-tab'" data-bs-toggle="tab" :data-bs-target="'#'.$value" type="button" role="tab" :aria-controls="$value" aria-selected="true"><slot></slot></button>
</li>