<?php
namespace Controllers\Mnt;

use Controllers\PublicController;
use Exception;
use Views\Renderer;

class Linea extends PublicController{
    private $redirectTo = "index.php?page=Mnt-Lineas";
    private $viewData = array(
        "mode" => "DSP",
        "modedsc" => "",
        "idlinea" => 0,
        "tipo_linea" => "",
        "tipo_linea_error"=> "",
        "general_errors"=> array(),
        "has_errors" =>false,
        "show_action" => true,
        "readonly" => false,
    );
    private $modes = array(
        "DSP" => "Detalle de %s",
        "INS" => "Nueva Linea",
        "UPD" => "Editar %s",
        "DEL" => "Borrar %s"
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
            unset($_SESSION["xssToken_Mnt_Linea"]);
            error_log(sprintf("Controller/Mnt/Linea ERROR: %s", $error->getMessage()));
            \Utilities\Site::redirectToWithMsg(
                $this->redirectTo,
                "Algo Inesperado Sucedió. Intente de Nuevo."
            );
        }

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
            if(isset($_GET['idlinea'])){
                $this->viewData["idlinea"] = intval($_GET["idlinea"]);
            } else {
                throw new Exception("Id not found on Query Params");
            }
        }
    }


    private function validatePostData(){
        if(isset($_POST["xssToken"])){
            if(isset($_SESSION["xssToken_Mnt_Linea"])){
                if($_POST["xssToken"] !== $_SESSION["xssToken_Mnt_Linea"]){
                    throw new Exception("Invalid Xss Token no match");
                }
            }else{
                throw New Exception("INVALID XSS TOKEN on SESSION");
            }
        }else{
            throw New Exception("INVALID XSS TOKEN");
        }
        if(isset($_POST["tipo_linea"])){
            if(\Utilities\Validators::IsEmpty($_POST["tipo_linea"])){
                $this->viewData["has_errors"] = true;
                $this->viewData["tipo_linea_error"] = "El tipo Linea no puede ir vacío!";
            }
        } else {
            throw new Exception("Id not present in form");
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

        if(isset($_POST["idlinea"])){
            if(($this->viewData["mode"] !== "INS" && intval($_POST["idlinea"])<=0)){
                throw new Exception("Linea id is not Valid");
            }
            if($this->viewData["idlinea"]!== intval($_POST["idlinea"])){
                throw new Exception("Linea id value is different from query");
            }
        }else {
            throw new Exception("Linea id not present in form");
        }
        $this->viewData["tipo_linea"] = $_POST["tipo_linea"];
        
    }
    private function executeAction(){
        switch($this->viewData["mode"]){
            case "INS":
                $inserted = \Dao\Mnt\Lineas::insert(
                    $this->viewData["tipo_linea"],
                  
                );
                if($inserted > 0){
                    \Utilities\Site::redirectToWithMsg(
                        $this->redirectTo,
                        "Linea Creada Exitosamente"
                    );
                }
                break;
            case "UPD":
                $updated = \Dao\Mnt\Lineas::update(
                    $this->viewData["tipo_linea"],
                    $this->viewData["idlinea"]
                );
                if($updated > 0){
                    \Utilities\Site::redirectToWithMsg(
                        $this->redirectTo,
                        "Linea Actualizado Exitosamente"
                    );
                }
                break;
            case "DEL":
                $deleted = \Dao\Mnt\Lineas::delete(
                    $this->viewData["idlinea"]
                );
                if($deleted > 0){
                    \Utilities\Site::redirectToWithMsg(
                        $this->redirectTo,
                        "Linea Eliminada Exitosamente"
                    );
                }
                break;
        }
    }
    private function render(){
        $xssToken = md5("MESSAGE" . rand(0,4000) * rand(5000,9999));
        $this->viewData["xssToken"] = $xssToken;
        $_SESSION["xssToken_Mnt_Linea"] = $xssToken;
        if($this->viewData["mode"] === "INS") {
            $this->viewData["modedsc"] = $this->modes["INS"];
        } else {
            $tmpLineas = \Dao\Mnt\Lineas::findById($this->viewData["idlinea"]);
            if(!$tmpLineas){
                throw new Exception("Linea no existe en DB");
            }
           
            \Utilities\ArrUtils::mergeFullArrayTo($tmpLineas, $this->viewData);
             
            $this->viewData["modedsc"] = sprintf(
                $this->modes[$this->viewData["mode"]],
                $this->viewData["tipo_linea"],
                $this->viewData["idlinea"]
            );
            if(in_array($this->viewData["mode"], array("DSP","DEL"))){
                $this->viewData["readonly"] = "readonly";
            }
            if($this->viewData["mode"] === "DSP") {
                $this->viewData["show_action"] = false;
            }
        }
        Renderer::render("mnt/linea", $this->viewData);}
    }
?>