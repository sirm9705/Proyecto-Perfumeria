<?php
namespace Dao\Mnt;

use Dao\Table;

class Clientes extends Table{
    /**
     * Crea un nuevo registro de categoria.
     *
     * @param string $cliente_nom description
     * @param string $cliente_email description
     * @param string $cliente_telefono1 description
     * @param string $cliente_gen description
     * @param string $cliente_direccion description
     * @param string $cliente_telefono2 description
     *
     * @return int
     */
    public static function insert(string $cliente_nom, string $cliente_email, string $cliente_telefono1, string $cliente_gen, string $cliente_direccion,  string $cliente_telefono2): int
    {
        $sqlstr = "INSERT INTO clientes (cliente_nom, cliente_email, cliente_telefono1, cliente_gen, cliente_direccion, cliente_telefono2) values(:cliente_nom , :cliente_email , :cliente_telefono1, :cliente_gen , :cliente_direccion, :cliente_telefono2);";
        $rowsInserted = self::executeNonQuery(
            $sqlstr,
            array("cliente_nom" => $cliente_nom, "cliente_email"=>$cliente_email , "cliente_telefono1"=>$cliente_telefono1, "cliente_gen"=>$cliente_gen, "cliente_direccion"=>$cliente_direccion, "cliente_telefono2"=>$cliente_telefono2)
        );
        return $rowsInserted;
    }
    public static function update(
        string $cliente_nom,
        string $cliente_email, 
        string $cliente_telefono1, 
        string $cliente_gen, 
        string $cliente_direccion, 
        string $cliente_telefono2,
        int $clienteid
    ){
        $sqlstr = "UPDATE clientes set cliente_nom = :cliente_nom, cliente_email = :cliente_email, cliente_telefono1 = :cliente_telefono1, cliente_gen = :cliente_gen, cliente_direccion= :cliente_direccion, cliente_telefono2= :cliente_telefono2 where clienteid=:clienteid;";
        $rowsUpdated = self::executeNonQuery(
            $sqlstr,
            array(
                "cliente_nom" => $cliente_nom, 
                "cliente_email"=>$cliente_email, 
                "cliente_telefono1"=>$cliente_telefono1,
                "cliente_gen"=>$cliente_gen, 
                "cliente_direccion"=>$cliente_direccion, 
                "cliente_telefono2"=>$cliente_telefono2,
                "clienteid" => $clienteid
            )
        );
        return $rowsUpdated;
    }
    public static function delete(int $clienteid){
        $sqlstr = "DELETE from clientes where clienteid=:clienteid;";
        $rowsDeleted = self::executeNonQuery(
            $sqlstr,
            array(
                "clienteid" => $clienteid
            )
        );
        return $rowsDeleted;
    }
    public static function findAll(){
        $sqlstr = "SELECT * from clientes;";
        return self::obtenerRegistros($sqlstr, array());
    }
    public static function findByFilter(){

    }
    public static function findById(int $clienteid){
        $sqlstr = "SELECT * from clientes where clienteid = :clienteid;";
        $row = self::obtenerUnRegistro(
            $sqlstr,
            array(
                "clienteid"=> $clienteid
            )
        );
        return $row;
    }
}
?>