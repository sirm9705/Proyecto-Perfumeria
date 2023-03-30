<?php
    namespace Dao\Mnt;

    use Dao\Table;

    class Products extends Table
    {
        public static function findAll()
        {
            $sqlstr = "SELECT * FROM productos";
            return self::obtenerRegistros($sqlstr,array());
        }

        public static function findById(int $idproducto){
            $sqltr = "SELECT * FROM productos where idproducto=:idproducto";
            $row=self::obtenerUnRegistro(
                $sqltr,
                array("idproducto"=>$idproducto));
            return $row;
        }

        public static function insert(string $nom_prod, string $desc_prod, float $precio, int $idmarca, string $fecha_vencimiento,$img)
        {
            $sqlstr = "INSERT INTO productos ( nom_prod,desc_prod,precio,idmarca, fecha_vencimiento,img) VALUES (:nom_prod,:clientgender,:precio,:idmarca,:fecha_vencimiento,:img)";
            $rowInserted=self::executeNonQuery(
                $sqlstr,
                array(
                "nom_prod"=>$nom_prod,
                "desc_prod"=>$desc_prod,
                "precio"=>$precio,
                "idmarca"=>$idmarca,
                "fecha_vencimiento"=>$fecha_vencimiento,
                "img"=>$img,
            ));
            return $rowInserted;
        }
        public static function update(int $idproducto,string $nom_prod, string $desc_prod, float $precio, int $idmarca, string $fecha_vencimiento,$img)
        {
            $sqlst="UPDATE INTO productos set nom_prod= :nom_prod, desc_prod=:desc_prod,precio=:precio,idmarca=:idmarca,fecha_vencimiento=:fecha_vencimiento,img=:img WHERE idproducto=:idproducto";
            $rowsUpdate = self::executeNonQuery(
                $sqlst,
                array(
                    "nom_prod"=>$nom_prod,
                    "desc_prod"=>$desc_prod,
                    "precio"=>$precio,
                    "idmarca"=>$idmarca,
                    "fecha_vencimiento"=>$fecha_vencimiento,
                    "img"=>$img,
                    "idproducto"=>$idproducto
                ));
            return $rowsUpdate;
        }

        public static function delete(int $idproducto){
            $sqlst = "DELETE FROM productos WHERE idproducto=:idproducto";
            $rowsDelete = self::executeNonQuery(
                $sqlst,
                array("idproducto"=>$idproducto));
            return $rowsDelete;
        }
    }
?>