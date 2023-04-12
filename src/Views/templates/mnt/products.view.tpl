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
                  <button id="btnAdd">Nuevo</button>
                </th>
            </tr>
        </thead>
        <tbody>
           {{foreach products}}
                <tr>
                    <td>{{idproducto}}</td>
                    <td><a href="index.php?page=Mnt-Product&mode=DISP&idproducto={{idproducto}}">{{nom_prod}}</a></td>
                    <td>{{desc_prod}}</td>
                    <td>{{precio}}</td>
                    <td>{{idmarca}}</td>
                    <td>{{fecha_vencimiento}}</td>
                    <td>
                      <img src="{{img}}" width:100>
                    </td>
                    <td>
                      <form action="index.php" method="get">
                        <input type="hidden" name="page" value="mnt_product" />
                        <input type="hidden" name="mode" value="UPD" />
                        <input type="hidden" name="idproducto" value="{{idproducto}}" />
                        <button type="submit">Editar</button>
                      </form>
                      <form action="index.php" method="get">
                        <input type="hidden" name="page" value="mnt_product" />
                          <input type="hidden" name="mode" value="DEL" />
                          <input type="hidden" name="idproducto" value="{{idproducto}}" />
                        <button type="submit">Eliminar</button>
                      </form>
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