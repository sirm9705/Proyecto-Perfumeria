
<h1>Gestión de Marcas</h1>
<section class="WWFilter">
  

</section>
<section class="WWList">
  <table>
    <thead>
      <tr>
        <th>Código</th>
        <th>Nombre</th>
        <th>Descripción</th>
        <th>
          {{if new_enabled}}
          <button id="btnAdd">Nuevo</button>
          {{endif new_enabled}}
        </th>
      </tr>
    </thead>
    <tbody>
      {{foreach marcas}}
      <tr>
        <td>{{idmarca}}</td>
        <td><a href="index.php?page=mnt_marca&mode=DSP&idmarca={{idmarca}}">{{marca_nom}}</a></td>
        <td>{{marca_descripcion}}</td>
        <td>
          {{if ~edit_enabled}}
          <form action="index.php" method="get">
             <input type="hidden" name="page" value="mnt_marca"/>
              <input type="hidden" name="mode" value="UPD" />
              <input type="hidden" name="idmarca" value={{idmarca}} />
              <button type="submit">Editar</button>
          </form>
          {{endif ~edit_enabled}}
          {{if ~delete_enabled}}
          <form action="index.php" method="get">
             <input type="hidden" name="page" value="mnt_marca"/>
              <input type="hidden" name="mode" value="DEL" />
              <input type="hidden" name="idmarca" value={{idmarca}} />
              <button type="submit">Eliminar</button>
          </form>
          {{endif ~delete_enabled}}
        </td>
      </tr>
      {{endfor marcas}}
    </tbody>
  </table>
</section>
<script>
   document.addEventListener("DOMContentLoaded", function () {
      document.getElementById("btnAdd").addEventListener("click", function (e) {
        e.preventDefault();
        e.stopPropagation();
        window.location.assign("index.php?page=mnt_marca&mode=INS&idmarca=0");
      });
    });
</script>
