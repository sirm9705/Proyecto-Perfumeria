<h1>{{modedsc}}</h1>
<section class="row">
    <form action="index.php?page=Mnt_Cliente&mode={{mode}}&clienteid={{clienteid}}"
        method="POST"
        class="col-6 col-3-offset"
    >
        <section class="row">
        <label for="clienteid" class="col-4">Código</label>
        <input type="hidden" id="clienteid" name="clienteid" value="{{clienteid}}"/>
        <input type="hidden" id="mode" name="mode" value="{{mode}}"/>
        <input type="text" readonly name="clienteiddummy" value="{{clienteid}}"/>
        </section>

        <section class="row">
        <label for="cliente_nom" class="col-4">Nombre</label>
        <input type="text" {{readonly}} name="cliente_nom" value="{{cliente_nom}}" maxlength="45" placeholder="Nombre de Cliente"/>
        {{if cliente_nom_error}}
            <span class="error col-12">{{cliente_nom_error}}</span>
        {{endif cliente_nom_error}}
        </section>
        
        <section class="row">
        <label for="cliente_gen" class="col-4">Genero</label>
        <select id="cliente_gen" name="cliente_gen" {{if readonly}}disabled{{endif readonly}}>
            <option value="M" {{cliente_gen_M}}>Masculino</option>
            <option value="F" {{cliente_gen_F}}>Femenino</option>
        </select>
        </section>

        <section class="row">
        <label for="cliente_telefono1" class="col-4">Telefono 1</label>
        <input type="number" {{readonly}} name="cliente_telefono1" value="{{cliente_telefono1}}" maxlength="45" placeholder="Numero del Cliente"/>
        </section>

        <section class="row">
        <label for="cliente_telefono2" class="col-4">Telefono 2</label>
        <input type="number" {{readonly}} name="cliente_telefono2" value="{{cliente_telefono2}}" maxlength="45" placeholder="Numero del Cliente"/>
        </section>
        
        <section class="row">
        <label for="cliente_email" class="col-4">Correo</label>
        <input type="email" {{readonly}} name="cliente_email" value="{{cliente_email}}" maxlength="45" placeholder="Correo del Cliente"/>
        </section>

        <section class="row">
        <label for="cliente_direccion" class="col-4">Direccion</label>
        <input type="text" {{readonly}} name="cliente_direccion" value="{{cliente_direccion}}" maxlength="255" placeholder="Direccion del Cliente"/>
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
            window.location.assign("index.php?page=Mnt_Clientes");
        });
    });
</script>