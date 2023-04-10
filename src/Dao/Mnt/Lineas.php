<?php
    namespace Dao\Mnt;

    use Dao\Table;

    class Lienas extends Table
    {
        public static function findAll()
        {
            $sqlstr = "SELECT * FROM linea";
            return self::obtenerRegistros($sqlstr,array());
        }

        public static function findById(int $idlinea){
            $sqltr = "SELECT * FROM linea where idlinea=:idlinea";
            $row=self::obtenerUnRegistro(
                $sqltr,
                array("idlinea"=>$idlinea));
            return $row;
        }

        public static function insert(string $nom_prod, string $desc_prod, float $precio, int $idmarca, string $fecha_vencimiento,$img)
        {
            $sqlstr = "INSERT INTO linea (tipo_linea) VALUES (:tipo_linea)";
            $rowInserted=self::executeNonQuery(
                $sqlstr,
                array(
                "tipo_ linea"=>$tipo_linea
            ));
            return $rowInserted;
        }
        public static function update(int $idlinea,string $tipo_linea)
        {
            $sqlst="UPDATE INTO linea set tipo_linea= :tipo_linea WHERE idlinea=:idlinea";
            $rowsUpdate = self::executeNonQuery(
                $sqlst,
                array(
                    "tipo_linea"=>$tipo_linea,
                    "idlinea"=>$idlinea
                ));
            return $rowsUpdate;
        }

        public static function delete(int $idlinea){
            $sqlst = "DELETE FROM linea WHERE idlinea=:idlinea";
            $rowsDelete = self::executeNonQuery(
                $sqlst,
                array("idlinea"=>$idlinea));
            return $rowsDelete;
        }
    }
?>