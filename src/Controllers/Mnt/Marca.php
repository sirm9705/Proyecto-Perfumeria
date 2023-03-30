<?php
namespace Controllers\Mnt;

use Controllers\PublicController;
use Exception;
use Views\Renderer;

class Marca extends PublicController{
    private $redirectTo = "index.php?page=Mnt_Marcas";
    private $viewData = array(
        "mode" => "DSP",
        "modedsc" => "",
        "idmarca" => 0,
        "marca_nom" => "",
        "marca_descripcion" => "",
        "marca_nom_error"=> "",
        "general_errors"=> array(),
        "has_errors" =>false,
        "show_action" => true,
        "readonly" => false,
        "xssToken" =>""
    );
    private $modes = array(
        "DSP" => "Detalle de %s (%s)",
        "INS" => "Nueva Marca",
        "UPD" => "Editar %s (%s)",
        "DEL" => "Borrar %s (%s)"
    );
    public function run() :void
    {
        try {
            $this->page_loaded();
            if($this->isPostBack()){
                $this->validatePostData();
                if(!$this->viewData["has_errors"]){
                    $this->executeAction();
                }
            }
            $this->render();
        } catch (Exception $error) {
            unset($_SESSION["xssToken_Mnt_Marcas"]);
            error_log(sprintf("Controller/Mnt/Marcas ERROR: %s", $error->getMessage()));
            \Utilities\Site::redirectToWithMsg(
                $this->redirectTo,
                "Algo Inesperado Sucedió. Intente de Nuevo."
            );
        }
        /*
        1) Captura de Valores Iniciales QueryParams -> Parámetros de Query ? 
            https://ax.ex.com/index.php?page=abc&mode=UPD&id=1029
        2) Determinamos el método POST GET
        3) Procesar la Entrada
            3.1) Si es un POST
            3.2) Capturar y Validara datos del formulario
            3.3) Según el modo realizar la acción solicitada
            3.4) Notificar Error si hay
            3.5) Redirigir a la Lista
            4.1) Si es un GET
            4.2) Obtener valores de la DB sin no es INS
            4.3) Mostrar Valores
        4) Renderizar
        */

    }
    private function page_loaded()
    {
        if(isset($_GET['mode'])){
            if(isset($this->modes[$_GET['mode']])){
                $this->viewData["mode"] = $_GET['mode'];
            } else {
                throw new Exception("Mode Not available");
            }
        } else {
            throw new Exception("Mode not defined on Query Params");
        }
        if($this->viewData["mode"] !== "INS") {
            if(isset($_GET['idmarca'])){
                $this->viewData["idmarca"] = intval($_GET["idmarca"]);
            } else {
                throw new Exception("Id not found on Query Params");
            }
        }
    }
    private function validatePostData(){
        if(isset($_POST["xssToken"])){
            if(isset($_SESSION["xssToken_Mnt_Marca"])){
                if($_POST["xssToken"] !== $_SESSION["xssToken_Mnt_Marca"]){
                    throw new Exception("Invalid Xss Token no match");
                }
            } else {
                throw new Exception("Invalid Xss Token on Session");
            }
        } else {
            throw new Exception("Invalid Xss Token");
        }
        if(isset($_POST["marca_nom"])){
            if(\Utilities\Validators::IsEmpty($_POST["marca_nom"])){
                $this->viewData["has_errors"] = true;
                $this->viewData["marca_nom_error"] = "El nombre no puede ir vacío!";
            }
        } else {
            throw new Exception("Nombre Marca not present in form");
        }
        if(isset($_POST["mode"])){
            if(!key_exists($_POST["mode"], $this->modes)){
                throw new Exception("mode has a bad value");
            }
            if($this->viewData["mode"]!== $_POST["mode"]){
                throw new Exception("mode value is different from query");
            }
        }else {
            throw new Exception("mode not present in form");
        }
        if(isset($_POST["idmarca"])){
            if(($this->viewData["mode"] !== "INS" && intval($_POST["idmarca"])<=0)){
                throw new Exception("Marca ID is not Valid");
            }
            if($this->viewData["idmarca"]!== intval($_POST["idmarca"])){
                throw new Exception("Marca ID value is different from query");
            }
        }else {
            throw new Exception("idmarca not present in form");
        }
        $this->viewData["marca_nom"] = $_POST["marca_nom"];
        if($this->viewData["mode"]!=="DEL"){
            $this->viewData["marca_descripcion"] = $_POST["marca_descripcion"];
        }
    }
    private function executeAction(){
        switch($this->viewData["mode"]){
            case "INS":
                $inserted = \Dao\Mnt\Marcas::insert(
                    $this->viewData["marca_nom"],
                    $this->viewData["marca_descripcion"]
                );
                if($inserted > 0){
                    \Utilities\Site::redirectToWithMsg(
                        $this->redirectTo,
                        "Marca Creada Exitosamente"
                    );
                }
                break;
            case "UPD":
                    $updated = \Dao\Mnt\Marcas::update(
                    $this->viewData["marca_nom"],
                    $this->viewData["marca_descripcion"],
                    $this->viewData["idmarca"]
                );
                if($updated > 0){
                    \Utilities\Site::redirectToWithMsg(
                        $this->redirectTo,
                        "Marca Actualizada Exitosamente"
                    );
                }
                break;
            case "DEL":
                $deleted = \Dao\Mnt\Marcas::delete(
                    $this->viewData["idmarca"]
                );
                if($deleted > 0){
                    \Utilities\Site::redirectToWithMsg(
                        $this->redirectTo,
                        "Marca Eliminada Exitosamente"
                    );
                }
                break;
        }
    }
    private function render(){
        $xssToken = md5("MARCA" . rand(0,4000) * rand(5000, 9999));
        $this->viewData["xssToken"] = $xssToken;
        $_SESSION["xssToken_Mnt_Marca"] = $xssToken;

        if($this->viewData["mode"] === "INS") {
            $this->viewData["modedsc"] = $this->modes["INS"];
        } else {
            $tmpMarcas = \Dao\Mnt\Marcas::finbyid($this->viewData["idmarca"]);
            if(!$tmpMarcas){
                throw new Exception("Marca no existe en DB");
            }
            \Utilities\ArrUtils::mergeFullArrayTo($tmpMarcas, $this->viewData);
            $this->viewData["modedsc"] = sprintf(
                $this->modes[$this->viewData["mode"]],
                $this->viewData["marca_nom"],
                $this->viewData["idmarca"]
            );
            if(in_array($this->viewData["mode"], array("DEL"))){
                $this->viewData["readonly"] = "readonly";
            }
            if($this->viewData["mode"] === "DSP") {
                $this->viewData["show_action"] = false;
            }
        }
        Renderer::render("mnt/marca", $this->viewData);
    }
}
?>