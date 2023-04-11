<?php
/**
 * PHP Version 7
 * Modelo de Datos para modelo
 *
 * @category Data_Model
 * @package  Models${1:modelo}
 * @author   Orlando J Betancourth <orlando.betancourth@gmail.com>
 * @license  Comercial http://
 *
 * @version 1.0.0
 *
 * @link http://url.com
 */

namespace Dao\Mnt;

use Dao\Table;

/**
 * Modelo de Datos para la tabla de proveedor
 *
 * @category Data_Model
 * @package  Dao.Table
 * @author   Orlando J Betancourth <orlando.betancourth@gmail.com>
 * @license  Comercial http://
 *
 * @link http://url.com
 */
class Proveedores extends Table
{
    /*
        `invPrdId` bigint(13) NOT NULL AUTO_INCREMENT,
        `invPrdBrCod` varchar(128) DEFAULT NULL,
        `invPrdCodInt` varchar(128) DEFAULT NULL,
        `invPrdDsc` varchar(128) DEFAULT NULL,
        `invPrdTip` char(3) DEFAULT NULL,
        `invPrdEst` char(3) DEFAULT NULL,
        `invPrdPadre` bigint(13) DEFAULT NULL,
        `invPrdFactor` int(11) DEFAULT NULL,
        `invPrdVnd` char(3) DEFAULT NULL,
    */
    /**
     * Obtiene todos los registros de Proveedores
     *
     * @return array
     */
    public static function getAll()
    {
        $sqlstr = "Select * from proveedor;";
        return self::obtenerRegistros($sqlstr, array());
    }
    /**
     * Get Producto By Id
     *
     * @param int $idprov Codigo del Producto
     *
     * @return array
     */
    public static function getById(int $idprov)
    {
        $sqlstr = "SELECT * from `proveedor` where idprov=:idprov;";
        $sqlParams = array("idprov" => $idprov);
        return self::obtenerUnRegistro($sqlstr, $sqlParams);
    }

    /**
     * Insert into proveedor
     *
     * @param [type] $prov_nom description
     * @param [type] $prov_telefono1 description
     * @param [type] $prov_telefono2 description
     * @param [type] $prov_email description
     * @param [type] $prov_direccion description
     * @param [type] $prov_descrip description
     *
     * @return void
     */
    public static function insert(
        $prov_nom,
        $prov_telefono1,
        $prov_telefono2,
        $prov_email,
        $prov_direccion,
        $prov_descrip
    ) {
        $sqlstr = "INSERT INTO proveedor (
            prov_nom,
            prov_telefono1,
            prov_telefono2,
            prov_email,
            prov_direccion,
            prov_descrip)
        VALUES
        (
        :prov_nom,
        :prov_telefono1,
        :prov_telefono2,
        :prov_email,
        :prov_direccion,
        :prov_descrip);
        ";
        $sqlParams = [
            "prov_nom" => $prov_nom,
            "prov_telefono1" => $prov_telefono1,
            "prov_telefono2" => $prov_telefono2,
            "prov_email" => $prov_email,
            "prov_direccion" => $prov_direccion,
            "prov_descrip" => $prov_descrip
        ];
        return self::executeNonQuery($sqlstr, $sqlParams);
    }
    /**
     * Updates proveedor
     *
     * @param [type] $idprov description
     * @param [type] $prov_nom description
     * @param [type] $prov_telefono1 description
     * @param [type] $prov_telefono2 description
     * @param [type] $prov_email description
     * @param [type] $prov_direccion description
     * @param [type] $prov_descrip description
     *
     * @return void
     */
    public static function update(
        $idprov,
        $prov_nom,
        $prov_telefono1,
        $prov_telefono2,
        $prov_email,
        $prov_direccion,
        $prov_descrip
    ) {
        $sqlstr = "UPDATE `proveedor`
        SET
        `prov_nom` = :prov_nom,
        `prov_telefono1` = :prov_telefono1,
        `prov_telefono2` = :prov_telefono2,
        `prov_email` = :prov_email,
        `prov_direccion` = :prov_direccion,
        `prov_descrip` = :prov_descrip
        WHERE `idprov` = :idprov
        ;";
        $sqlParams = array(            
            "prov_nom" => $prov_nom,
            "prov_telefono1" => $prov_telefono1,
            "prov_telefono2" => $prov_telefono2,
            "prov_email" => $prov_email,
            "prov_direccion" => $prov_direccion,
            "prov_descrip" => $prov_descrip,
            "idprov" => $idprov
        );

        return self::executeNonQuery($sqlstr, $sqlParams);
    }

    /**
     * Undocumented function
     *
     * @param [type] $idprov description
     *
     * @return void
     */
    public static function delete( $idprov )
    {
        $sqlstr = "DELETE from `proveedor` where idprov = :idprov;";
        $sqlParams = array(
            "idprov" => $idprov
        );
        return self::executeNonQuery($sqlstr, $sqlParams);
    }

}
