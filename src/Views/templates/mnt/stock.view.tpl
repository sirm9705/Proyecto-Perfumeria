<h1>{{modedsc}}</h1>
<section class="row">
  <form action="index.php?page=Mnt_Stock&mode={{mode}}&idstock={{idstock}}"
    method="POST"
    class="col-6 col-3-offset"
  >
    <section class="row">
    <label for="idstock" class="col-4">Código</label>
    <input type="hidden" id="idstock" name="idstock" value="{{idstock}}"/>
    <input type="hidden" id="mode" name="mode" value="{{mode}}"/>
    <input type="hidden"  name="xssToken" value="{{xssToken}}"/>
    <input type="text" readonly name="idstockdummy" value="{{idstock}}"/>
    </section>
    <section class="row">
      <label for="cantidad" class="col-4">Cantidad</label>
      <input type="text" {{readonly}} name="cantidad" value="{{cantidad}}" maxlength="45" placeholder="Cantidad"/>
      {{if cantidad_error}}
        <span class="error col-12">{{cantidad_error}}</span>
      {{endif cantidad_error}}
    </section>
    <section class="row">
      <label for="estado" class="col-4">Estado</label>
      <select id="estado" name="estado" {{if readonly}}disabled{{endif readonly}}>
        <option value="ACT" {{estado_ACT}}>Activo</option>
        <option value="INA" {{estado_INA}}>Inactivo</option>
      </select>
    </section>

    <section class="row">
      <label for="idproducto" class="col-4">Id de Producto</label>
      <input type="text" {{readonly}} name="idproducto" value="{{idproducto}}" maxlength="45" placeholder="Id de Producto"/>
    </section>

    {{if has_errors}}
        <section>
          <ul>
            {{foreach general_errors}}
                <li>{{this}}</li>
            {{endfor general_errors}}
          </ul>
        </section>
    {{endif has_errors}}
    <section>
      {{if show_action}}
      <button type="submit" name="btnGuardar" value="G">Guardar</button>
      {{endif show_action}}
      <button type="button" id="btnCancelar">Cancelar</button>
    </section>
  </form>
</section>


<script>
  document.addEventListener("DOMContentLoaded", function(){
      document.getElementById("btnCancelar").addEventListener("click", function(e){
        e.preventDefault();
        e.stopPropagation();
        window.location.assign("index.php?page=Mnt_Stocks");
      });
  });
</script>