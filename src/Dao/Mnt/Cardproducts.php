<?php
    namespace Dao\Mnt;

    use Dao\Table;

    class Cardproducts extends Table
    {
        public static function findAll()
        {
            $sqlstr = "Select p.idproducto, p.nom_prod,p.precio, m.marca_nom,p.desc_prod,s.cantidad, p.fecha_vencimiento,p.img FROM productos  p inner join stock s on p.idproducto = s.idproducto inner join marca m on p.idmarca = m.idmarca where s.estado =  'Disponible';";
            return self::obtenerRegistros($sqlstr,array());
        }
    }
?>