<?php
namespace Dao\Mnt;

use Dao\Table;
/*

 */
/**
 * Class Stocks
 */
class Stocks extends Table{
    /**
     * 
     *
     *
     * @return int
     */
    public static function insert(int $cantidad, string $estado="ACT", int $idproducto): int
    {
        $sqlstr = "INSERT INTO stock (cantidad, estado, idproducto) values(:cantidad, :estado, idproducto);";
        $rowsInserted = self::executeNonQuery(
            $sqlstr,
            array("cantidad"=>$cantidad, "estado"=>$estado, "idproducto" => $idproducto)
        );
        return $rowsInserted;
    }
    
    public static function update(
        int $cantidad,
        string $estado,
        int $idproducto,
        int $idstock
    ){
        $sqlstr = "UPDATE stock set cantidad = :cantidad, estado = :estado, idproducto = :idproducto where idstock=:idstock;";
        $rowsUpdated = self::executeNonQuery(
            $sqlstr,
            array(
                "cantidad" => $cantidad,
                "estado" => $estado,
                "idproducti" => $idproducto,
                "idstock" => $idstock
            )
        );
        return $rowsUpdated;
    }
    public static function delete(int $idstock){
        $sqlstr = "DELETE from stock where idstock=:idstock;";
        $rowsDeleted = self::executeNonQuery(
            $sqlstr,
            array(
                "idstock" => $idstock
            )
        );
        return $rowsDeleted;
    }
    public static function findAll(){
        $sqlstr = "SELECT * from stock;";
        return self::obtenerRegistros($sqlstr, array());
    }
    
    public static function findById(int $idstock){
        $sqlstr = "SELECT * from categorias where idstock = :idstock;";
        $row = self::obtenerUnRegistro(
            $sqlstr,
            array(
                "idstock"=> $idstock
            )
        );
        return $row;
    }
}

?>
