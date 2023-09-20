<fieldset>
  <legend>{t 'Data'}</legend>
  <x-form-group p-model="model" />            
  <x-form-group p-model="sku" />            
  <x-form-group p-model="upc" />            
  <x-form-group p-model="ean" />            
  <x-form-group p-model="jan" />            
  <x-form-group p-model="isbn" />            
  <x-form-group p-model="mpn" />            
  <x-form-group p-model="shipping" type="switch" /> 
  <div class="row">
      <x-form-group class="col-sm-3" p-model="volumetry.length" />            
      <x-form-group class="col-sm-3" p-model="volumetry.width" />            
      <x-form-group class="col-sm-3" p-model="volumetry.height" />            
      <x-form-group class="col-sm-3" p-model="volumetry.weight" />            
      <x-form-group class="col-sm-3" p-model="volumetry.length_class_id" />            
      <x-form-group class="col-sm-3" p-model="volumetry.weight_class_id" />            
  </div>
  <x-form-check p-model="status" type="switch" />
  <x-form-group p-model="sort_order" type="number"/>
</fieldset>