<style>
table {
  font-family: arial, sans-serif;
  border:1px solid black;
  border-collapse: collapse;

}

td, th {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 8px;
}
</style>
<h1>Trabajar con Proveedores</h1>
<section>

</section>
<section>
  <table>
    <thead>
      <tr>
        <th>Id</th>
        <th>Nombre</th>
        <th>Primer telefono</th>
        <th>Segundo telefono</th>
        <th>Correo</th>
        <th>Dirección</th>
        <th>Descripción</th>
        <th><a href="index.php?page=Mnt-Proveedor&mode=INS">Nuevo</a></th>
      </tr>
    </thead>
    <tbody>
      {{foreach Proveedores}}
      <tr>
        <td>{{idprov}}</td>
        <td> <a href="index.php?page=Mnt-Proveedor&mode=DSP&id={{idprov}}">{{prov_nom}}</a></td>
        <td>{{prov_telefono1}}</td>
        <td>{{prov_telefono2}}</td>
        <td>{{prov_email}}</td>
        <td>{{prov_direccion}}</td>
        <td>{{prov_descrip}}</td>
        <td>
          <a href="index.php?page=Mnt-Proveedor&mode=UPD&id={{idprov}}">Editar</a>
          &NonBreakingSpace;
          <a href="index.php?page=Mnt-Proveedor&mode=DEL&id={{idprov}}">Eliminar</a>
        </td>
      </tr>
      {{endfor Proveedores}}
    </tbody>
  </table>
</section>
