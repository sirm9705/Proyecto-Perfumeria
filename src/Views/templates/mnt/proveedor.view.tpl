<style> 
input[type=text], select, textarea {
  width: 100%;
  padding: 12px;
  border: 1px solid #ccc;
  border-radius: 4px;
  resize: vertical;
}

form {
  width: 50%;
}

label {
  padding: 12px 12px 12px 0;
  display: inline-block;
}
</style>
<h1>{{mode_desc}}</h1>
<section>
  <form action="index.php?page=mnt_proveedor" method="post">
    <input type="hidden" name="mode" value="{{mode}}" />
    <input type="hidden" name="crsf_token" value="{{crsf_token}}" />
    <input type="hidden" name="idprov" value="{{idprov}}" />
    <fieldset>
      <label for="prov_nom">Nombre Proveedor</label>
      <input {{if readonly}}readonly{{endif readonly}} type="text" id="prov_nom" name="prov_nom" placeholder="Nombre Proveedor" value="{{prov_nom}}"/>
      {{if error_prov_nom}}
        {{foreach error_prov_nom}}
          <div class="error">{{this}}</div>
        {{endfor error_prov_nom}}
      {{endif error_prov_nom}}
    </fieldset>
    <fieldset>
      <label for="prov_telefono1">Primer telefono</label>
      <input {{if readonly}}readonly{{endif readonly}} type="text" id="prov_telefono1" name="prov_telefono1" placeholder="Primer telefono" value="{{prov_telefono1}}" />
      {{if error_prov_telefono1}}
        {{foreach error_prov_telefono1}}
          <div class="error">{{this}}</div>
        {{endfor error_prov_telefono1}}
      {{endif error_prov_telefono1}}
    </fieldset>
    <fieldset>
      <label for="prov_telefono2">Segundo telefono</label>
      <input {{if readonly}}readonly{{endif readonly}} type="text" id="prov_telefono2" name="prov_telefono2" placeholder="Segundo telefono" value="{{prov_telefono2}}" />
      {{if error_prov_telefono2}}
          {{foreach error_prov_telefono2}}
            <div class="error">{{this}}</div>
          {{endfor error_prov_telefono2}}
      {{endif error_prov_telefono2}}
    </fieldset>
    <fieldset>
      <label for="prov_email">Email</label>
      <input {{if readonly}}readonly{{endif readonly}} type="text" id="prov_email" name="prov_email" placeholder="Email" value="{{prov_email}}" />
      {{if error_prov_email}}
          {{foreach error_prov_email}}
            <div class="error">{{this}}</div>
          {{endfor error_prov_email}}
      {{endif error_prov_email}}
    </fieldset>
    <fieldset>
      <label for="prov_direccion">Dirección</label>
      <input {{if readonly}}readonly{{endif readonly}} type="text" id="prov_direccion" name="prov_direccion" placeholder="Dirección" value="{{prov_direccion}}" />
      {{if error_prov_direccion}}
          {{foreach error_prov_direccion}}
            <div class="error">{{this}}</div>
          {{endfor error_prov_direccion}}
      {{endif error_prov_direccion}}
    </fieldset>
    <fieldset>
      <label for="prov_descrip">Descripción</label>
      <input {{if readonly}}readonly{{endif readonly}} type="text" id="prov_descrip" name="prov_descrip" placeholder="Descripción" value="{{prov_descrip}}" />
      {{if error_prov_descrip}}
          {{foreach error_prov_descrip}}
            <div class="error">{{this}}</div>
          {{endfor error_prov_descrip}}
      {{endif error_prov_descrip}}
    </fieldset>
    <fieldset>
      {{if showBtn}}
        <button type="submit" name="btnEnviar">{{btnEnviarText}}</button>
        &nbsp;
      {{endif showBtn}}
      <button name="btnCancelar" id="btnCancelar">Cancelar</button>
    </fieldset>
  </form>
</section>
<script>
  document.addEventListener('DOMContentLoaded', function(){
    document.getElementById('btnCancelar').addEventListener('click', function(e){
      e.preventDefault();
      e.stopPropagation();
      window.location.href = 'index.php?page=mnt_proveedores';
    });
  });
</script>
