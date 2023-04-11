<h1>Control de Productos</h1>
<section class="WWFilter">
</section>
<section class="WWList">
  <table>
        <thead>
            <tr>
                <th>Codigo</th>
                <th>Producto</th>
                <th>Descripcion</th>
                <th>Precio</th>
                <th>Marca</th>
                <th>Fecha Vencimiento</th>
                <th>Imagen</th>
                <th>
                  {{if new_enabled}}
                    <button id="btnAdd">Nuevo</button>
                  {{endif new_enabled}}
                </th>
            </tr>
        </thead>
        <tbody>
           {{foreach products}}
                <tr>
                    <td>{{idproducto}}</td>
                    <td><a href="index.php?page=mnt_product&mode=DSP&idproducto={{idproducto}}">{{nom_prod}}</a></td>
                    <td>{{desc_prod}}</td>
                    <td>{{precio}}</td>
                    <td>{{idmarca}}</td>
                    <td>{{fecha_vencimiento}}</td>
                    <td>
                      <img src="{{img}}" width="80px" height=auto>
                    </td>
                    <td>
                        {{if edit_enabled}}
                            <form action="index.php" method="get">
                                <input type="hidden" name="page" value="mnt_product" />
                                <input type="hidden" name="mode" value="UPD" />
                                <input type="hidden" name="idproducto" value="{{idproducto}}" />
                                <button type="submit">Editar</button>
                            </form>
                        {{endif edit_enabled}}
                        {{if edit_enabled}}
                             <form action="index.php" method="get">
                                <input type="hidden" name="page" value="mnt_product" />
                                <input type="hidden" name="mode" value="DEL" />
                                <input type="hidden" name="idproducto" value="{{idproducto}}" />
                                <button type="submit">Eliminar</button>
                             </form>
                        {{endif edit_enabled}}
                     </td>
                </tr>
           {{endfor products}}
        </tbody>
  </table>
</section>
<script>
   document.addEventListener("DOMContentLoaded", function () {
      document.getElementById("btnAdd").addEventListener("click", function (e) {
        e.preventDefault();
        e.stopPropagation();
        window.location.assign("index.php?page=mnt_product&mode=INS&idproducto=0");
      });
    });
</script>