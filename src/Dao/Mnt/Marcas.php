<?php

namespace Dao\Mnt;
use Dao\Table;

ini_set('display_errors', 1);
error_reporting(E_ALL);

ini_set("display_errors", 1);

class Marcas extends Table
{
    public static function insert(string $marca_nom, string $marca_descripcion): int
    {
        $sqlstr = "INSERT INTO marca (marca_nom, marca_descripcion) values (:marca_nom, :marca_descripcion);";
        $rowsInserted = self::executeNonQuery($sqlstr, array("marca_nom" => $marca_nom, "marca_descripcion" => $marca_descripcion));
        return $rowsInserted;
    }
    public static function update(
        string $marca_nom,
        string $marca_descripcion,
        int $idmarca
    ) {
        $sqlstr = "UPDATE marca set marca_nom = :marca_nom, marca_descripcion = :marca_descripcion where idmarca=:idmarca;";
        $rowsUpdated = self::executeNonQuery(
            $sqlstr,
            array(
                "marca_nom" => $marca_nom,
                "marca_descripcion" => $marca_descripcion,
                "idmarca" => $idmarca
            )
        );
        return $rowsUpdated;
    }
    public static function delete(int $idmarca)
    {
        $sqlstr = "DELETE from marca where idmarca=:idmarca;";
        $rowsDeleted = self::executeNonQuery(
            $sqlstr,
            array(
                "idmarca" => $idmarca
            )
        );
        return $rowsDeleted;
    }
    public static function findAll()
    {
        $sqlstr = "SELECT * FROM marca;";
        return self::obtenerRegistros($sqlstr, array());
    }
    public static function finbyid(int $idmarca)
    {
        $sqlstr = "SELECT * from marca where idmarca = :idmarca;";
        $row = self::obtenerUnRegistro(
            $sqlstr,
            array(
                "idmarca"=> $idmarca
            )
        );
        return $row;
    }
    public static function finbyfilter()
    {
    }
}
