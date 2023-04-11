<?php
    namespace Dao\Mnt;

    use Dao\Table;

    class Lineas extends Table
    {
        public static function insert(
            string $tipo_linea): int
        {
            $sqlstr = "INSERT INTO linea (tipo_linea) 
            values(:tipo_linea);";
            $rowsInserted = self::executeNonQuery(
                $sqlstr,
                array(
                    "tipo_linea"=>$tipo_linea
                    )
            );
            return $rowsInserted;
        }

        public static function update(
            string $tipo_linea,
            int $idlinea
        ){
            $sqlstr = "UPDATE linea set 
                tipo_linea = :tipo_linea  where idlinea=:idlinea;";
            $rowsUpdated = self::executeNonQuery(
                $sqlstr,
                array(
                    "tipo_linea" => $tipo_linea,
                    "idlinea" => $idlinea
                )
            );
            return $rowsUpdated;
        }

        public static function delete(int $idlinea){
            $sqlstr = "DELETE from linea where idlinea=:idlinea;";
            $rowsDeleted = self::executeNonQuery(
                $sqlstr,
                array(
                    "idlinea" => $idlinea
                )
            );
            return $rowsDeleted;
        }
        public static function findAll(){
            $sqlstr = "SELECT * from linea;";
            return self::obtenerRegistros($sqlstr, array());
        }
        public static function findByFilter(){
    
        }
        public static function findById(int $idlinea){
            $sqlstr = "SELECT * from linea where idlinea = :idlinea;";
            $row = self::obtenerUnRegistro(
                $sqlstr,
                array(
                    "idlinea"=> $idlinea
                )
            );
            return $row;
        }
    }
    ?>


