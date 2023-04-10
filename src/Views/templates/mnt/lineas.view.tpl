<h1>Control de Linea</h1>
<section class="WWFilter>
</section>
<section class="WWList>
  <table>
        <thead>
            <tr>
                <th>Codigo</th>
                <th>Tipo Linea</th>
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
                    <td>{{idlinea}}</td>
                    <td><a href="index.php?page=mnt_product&mode=DSP&idlinea={{idlinea}}">{{tipo_linea}}</a></td>
                    <td>{{tipo_linea}}</td>
                    <td>
                      <img src="{{img}}" width="80px" height=auto>
                    </td>
                    <td>
                        {{if edit_enabled}}
                            <form action="index.php" method="get">
                                <input type="hidden" name="page" value="mnt_linea" />
                                <input type="hidden" name="mode" value="UPD" />
                                <input type="hidden" name="idlinea" value="{{idlinea}}" />
                                <button type="submit">Editar</button>
                            </form>
                        {{endif edit_enabled}}
                        {{if edit_enabled}}
                             <form action="index.php" method="get">
                                <input type="hidden" name="page" value="mnt_linea" />
                                <input type="hidden" name="mode" value="DEL" />
                                <input type="hidden" name="idlinea" value="{{idlinea}}" />
                                <button type="submit">Eliminar</button>
                             </form>
                        {{endif edit_enabled}}
                     </td>
                </tr>
           {{endfor lineas}}
        </tbody>
  </table>
</section>
<script>
   document.addEventListener("DOMContentLoaded", function () {
      document.getElementById("btnAdd").addEventListener("click", function (e) {
        e.preventDefault();
        e.stopPropagation();
        window.location.assign("index.php?page=mnt_linea&mode=INS&idlinea=0");
      });
    });
</script>