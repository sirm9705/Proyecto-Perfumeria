<h1>Gestión de Stocks</h1>
<section class="WWFilter">

</section>
<section class="WWList">
  <table>
    <thead>
      <tr>
        <th>Código</th>
        <th>Cantidad</th>
        <th>Estado</th>
        <th>Id de Producto</th>
        <th>
          {{if new_enabled}}
          <button id="btnAdd">Nuevo</button>
          {{endif new_enabled}}
        </th>
      </tr>
    </thead>
    <tbody>
      {{foreach stocks}}
      <tr>
        <td>{{idstock}}</td>
        <td><a href="index.php?page=mnt_stock&mode=DSP&idstock={{idstock}}">{{cantidad}}</a></td>
        <td>{{estado}}</td>
        <td>{{idproducto}}</td>
        <td>
          {{if ~edit_enabled}}
          <form action="index.php" method="get">
             <input type="hidden" name="page" value="mnt_stock"/>
              <input type="hidden" name="mode" value="UPD" />
              <input type="hidden" name="idstock" value={{idstock}} />
              <button type="submit">Editar</button>
          </form>
          {{endif ~edit_enabled}}
          {{if ~delete_enabled}}
          <form action="index.php" method="get">
             <input type="hidden" name="page" value="mnt_stock"/>
              <input type="hidden" name="mode" value="DEL" />
              <input type="hidden" name="idstock" value={{idstock}} />
              <button type="submit">Eliminar</button>
          </form>
          {{endif ~delete_enabled}}
        </td>
      </tr>
      {{endfor stocks}}
    </tbody>
  </table>
</section>
<script>
   document.addEventListener("DOMContentLoaded", function () {
      document.getElementById("btnAdd").addEventListener("click", function (e) {
        e.preventDefault();
        e.stopPropagation();
        window.location.assign("index.php?page=mnt_stock&mode=INS&idstock=0");
      });
    });
</script>