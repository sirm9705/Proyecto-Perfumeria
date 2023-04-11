<h1>{{modedsc}}</h1>
<section class="row">
    <form action="index.php?page=Mnt_Linea&mode={{mode}}&idlinea={{idlinea}}"
        method="POST"
        class="col-6 col-3-offset"
    >

    
        <section class="row">
        <label for="idlinea" class="col-4">Codigo</label>
        <input type="hidden" id="idlinea" name="idlinea" value="{{idlinea}}"/>
        <input type="hidden" id="mode" name="mode" value="{{mode}}"/>
        <input type="hidden" name="xssToken" value="{{xssToken}}">
        <input type="text" readonly name="iddummy" value="{{idlinea}}"/>
        </section>

        <section class="row">
        <label for="tipo_linea" class="col-4">Tipo de Linea</label>
        <input type="text" {{readonly}} name="tipo_linea" value="{{tipo_linea}}" maxlength="45" placeholder="Tipo de Linea"/>
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
            window.location.assign("index.php?page=Mnt_Lineas");
        });
    });
</script>