<h>{{modedsc}}</h>
<section>
  <form action="index.php?page=mnt_linea&mode={{mode}}&idlinea={{idlinea}}" method="POST">
    <section>
        <label for="idlinea">Codigo</label>
        <input type"hidden" id="idlinea" value="{{idlinea}}"/>
        <input type="text" readonly name="clientiddummy" value="{{idlinea}}"/>
    </section>
    <section>
        <label for="tipo_linea">Producto</label>
        <input type="text" {{readonly}} name="tipo_linea" value="{{tipo_linea}}" maxlength="50">
        {{if "nom_prod_error"}}
            <span class="error">{{"nom_prod_error"}}</span>
        {{endif "nom_prod_error"}}
    </section>
    {{if has_errors}}
        <section>
            <ul>
                {{foreach general_error}}
                    <li>{{this}}</li>
                {{endfor general_error}}
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
        window.location.assign("index.php?page=mnt_linea");
      });
  });
</script>