<?php
/**
 * PHP Version 7.2
 * Mnt
 *
 * @category Controller
 * @package  Controllers\Mnt
 * @author   Orlando J Betancourth <orlando.betancourth@gmail.com>
 * @license  Comercial http://
 * @version  CVS:1.0.0
 * @link     http://url.com
 */
 namespace Controllers\Mnt;

// ---------------------------------------------------------------
// Sección de imports
// ---------------------------------------------------------------
use Controllers\PublicController;
use Views\Renderer;
use Utilities\Validators;
use Dao\Mnt\Proveedores;

/**
 * Proveedor
 *
 * @category Public
 * @package  Controllers\Mnt;
 * @author   Orlando J Betancourth <orlando.betancourth@gmail.com>
 * @license  MIT http://
 * @link     http://
 */
class Proveedor extends PublicController
{
    private $viewData = array();
    private $arrModeDesc = array();

    /**
     * Runs the controller
     *
     * @return void
     */
    public function run():void
    {
        // code
        $this->init();
        // Cuando es método GET (se llama desde la lista)
        if (!$this->isPostBack()) {
            $this->procesarGet();
        }
        // Cuando es método POST (click en el botón)
        if ($this->isPostBack()) {
            $this->procesarPost();
        }
        // Ejecutar Siempre
        $this->processView();
        Renderer::render('mnt/proveedor', $this->viewData);
    }

    private function init()
    {
        $this->viewData = array();
        $this->viewData["mode"] = "";
        $this->viewData["mode_desc"] = "";
        $this->viewData["crsf_token"] = "";

        $this->viewData["idprov"] = "";
        $this->viewData["prov_nom"] = "";
        $this->viewData["error_prov_nom"] = array();
        $this->viewData["prov_telefono1"] = "";
        $this->viewData["error_prov_telefono1"] = array();
        $this->viewData["prov_telefono2"] = "";
        $this->viewData["error_prov_telefono2"] = array();
        $this->viewData["prov_email"] = "";
        $this->viewData["error_prov_email"] = array();
        $this->viewData["prov_direccion"] = "";
        $this->viewData["error_prov_direccion"] = array();
        $this->viewData["prov_descrip"] = "";
        $this->viewData["error_prov_descrip"] = array();

        $this->viewData["btnEnviarText"] = "Guardar";
        $this->viewData["readonly"] = false;
        $this->viewData["showBtn"] = true;

        $this->arrModeDesc = array(
            "INS"=>"Nuevo Proveedor",
            "UPD"=>"Editando %s %s",
            "DSP"=>"Detalle de %s %s",
            "DEL"=>"Eliminado %s %s"
        );

    }

    private function procesarGet()
    {
        if (isset($_GET["mode"])) {
            $this->viewData["mode"] = $_GET["mode"];
            if (!isset($this->arrModeDesc[$this->viewData["mode"]])) {
                error_log('Error: (Proveedor) Mode solicitado no existe.');
                \Utilities\Site::redirectToWithMsg(
                    "index.php?page=mnt_proveedores",
                    "No se puede procesar su solicitud!"
                );
            }
        }
        if ($this->viewData["mode"] !== "INS" && isset($_GET["id"])) {
            $this->viewData["idprov"] = intval($_GET["id"]);
            $tmpProveedor = Proveedores::getById($this->viewData["idprov"]);
            error_log(json_encode($tmpProveedor));
            \Utilities\ArrUtils::mergeFullArrayTo($tmpProveedor, $this->viewData);
        }
    }
    private function procesarPost()
    {
        // Validar la entrada de Datos
        //  Todos valor puede y sera usando en contra del sistema
        $hasErrors = false;
        \Utilities\ArrUtils::mergeArrayTo($_POST, $this->viewData);
        if (isset($_SESSION[$this->name . "crsf_token"])
            && $_SESSION[$this->name . "crsf_token"] !== $this->viewData["crsf_token"]
        ) {
            \Utilities\Site::redirectToWithMsg(
                "index.php?page=mnt_proveedores",
                "ERROR: Algo inesperado sucedió con la petición Intente de nuevo."
            );
        }

        if (Validators::IsEmpty($this->viewData["prov_nom"])) {
            $this->viewData["error_prov_nom"][]
                = "El Nombre del Proveedor es requerido";
            $hasErrors = true;
        }
        if (Validators::IsEmpty($this->viewData["prov_telefono1"])) {
            $this->viewData["error_prov_telefono1"][]
                = "El primer telefono es requerido";
            $hasErrors = true;
        }
        if (Validators::IsEmpty($this->viewData["prov_telefono2"])) {
            $this->viewData["error_prov_telefono2"][]
                = "La segundo telefono es requerida";
            $hasErrors = true;
        }
        if (Validators::IsEmpty($this->viewData["prov_email"])) {
            $this->viewData["error_prov_email"][]
                = "La dirección de correo electronico es requerida";
            $hasErrors = true;
        }
        if (Validators::IsEmpty($this->viewData["prov_direccion"])) {
            $this->viewData["error_prov_direccion"][]
                = "La dirección es requerida";
            $hasErrors = true;
        }
        if (Validators::IsEmpty($this->viewData["prov_descrip"])) {
            $this->viewData["error_prov_descrip"][]
                = "La descripción es requerida";
            $hasErrors = true;
        }
        error_log(json_encode($this->viewData));
        // Ahora procedemos con las modificaciones al registro
        if (!$hasErrors) {
            $result = null;
            switch($this->viewData["mode"]) {
            case 'INS':
                $result = Proveedores::insert(
                    $this->viewData["prov_nom"],
                    $this->viewData["prov_telefono1"],
                    $this->viewData["prov_telefono2"],
                    $this->viewData["prov_email"],
                    $this->viewData["prov_direccion"],
                    $this->viewData["prov_descrip"]
                );
                if ($result) {
                        \Utilities\Site::redirectToWithMsg(
                            "index.php?page=mnt_proveedores",
                            "Proveedor Guardado Satisfactoriamente!"
                        );
                }
                break;
            case 'UPD':
                $result = Proveedores::update(
                    intval($this->viewData["idprov"]),
                    $this->viewData["prov_nom"],
                    $this->viewData["prov_telefono1"],
                    $this->viewData["prov_telefono2"],
                    $this->viewData["prov_email"],
                    $this->viewData["prov_direccion"],
                    $this->viewData["prov_descrip"]                
                );
                if ($result) {
                    \Utilities\Site::redirectToWithMsg(
                        "index.php?page=mnt_proveedores",
                        "Proveedor Actualizado Satisfactoriamente"
                    );
                }
                break;
            case 'DEL':
                $result = Proveedores::delete(
                    intval($this->viewData["idprov"])
                );
                if ($result) {
                    \Utilities\Site::redirectToWithMsg(
                        "index.php?page=mnt_proveedores",
                        "Proveedor Eliminado Satisfactoriamente"
                    );
                }
                break;
            }
        }
    }

    private function processView()
    {
        if ($this->viewData["mode"] === "INS") {
            $this->viewData["mode_desc"]  = $this->arrModeDesc["INS"];
            $this->viewData["btnEnviarText"] = "Guardar Nuevo";
        } else {
            $this->viewData["mode_desc"]  = sprintf(
                $this->arrModeDesc[$this->viewData["mode"]],
                $this->viewData["prov_nom"],
                $this->viewData["prov_telefono1"],
                $this->viewData["prov_telefono2"],
                $this->viewData["prov_email"],
                $this->viewData["prov_direccion"],
                $this->viewData["prov_descrip"]
            );
            

            if ($this->viewData["mode"] === "DSP") {
                $this->viewData["readonly"] = true;
                $this->viewData["showBtn"] = false;
            }
            if ($this->viewData["mode"] === "DEL") {
                $this->viewData["readonly"] = true;
                $this->viewData["btnEnviarText"] = "Eliminar";
            }
            if ($this->viewData["mode"] === "UPD") {
                $this->viewData["btnEnviarText"] = "Actualizar";
            }
        }
        $this->viewData["crsf_token"] = md5(getdate()[0] . $this->name);
        $_SESSION[$this->name . "crsf_token"] = $this->viewData["crsf_token"];
    }
}
