@php 
$attrs = $this->context->except(['class','method','action','multilang']);
@endphp
<form :action="$action" :method="in_array(strtolower($method), ['post', 'put']) ? 'POST' : 'GET'" encrypt="multipart/form-data" p-bind="$attrs" :class="[$class, isset($multilang) ? 'multilang' : '']">
  <x-form-control p-if="isset($multilang)" type="select" style="max-width:200px;" class="ms-auto js_formLangControl" :options="$languages" />
  <input name="_method" :value="$method" hidden>
  <csrf/>
  <slot></slot>
</form>