<?php
namespace Controllers\Mnt;

use Controllers\PublicController;
use Exception;
use Views\Renderer;

class Cliente extends PublicController{
    private $redirectTo = "index.php?page=Mnt-Clientes";
    private $viewData = array(
        "mode" => "DSP",
        "modedsc" => "",
        "clienteid" => 0,
        "cliente_nom" => "",
        "cliente_email" => "",
        "cliente_gen" => "M",
        "cliente_gen_M" => "selected",
        "cliente_gen_F" => "",
        "cliente_telefono1" => "",
        "cliente_telefono2" => "",
        "cliente_direccion" => "",
        "cliente_nom_error"=> "",
        "general_errors"=> array(),
        "has_errors" =>false,
        "show_action" => true,
        "readonly" => false,
    );
    private $modes = array(
        "DSP" => "Detalle de %s (%s)",
        "INS" => "Nuevo Cliente",
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
            error_log(sprintf("Controller/Mnt/Cliente ERROR: %s", $error->getMessage()));
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
            if(isset($_GET['clienteid'])){
                $this->viewData["clienteid"] = intval($_GET["clienteid"]);
            } else {
                throw new Exception("clienteid not found on Query Params");
            }
        }
    }
    private function validatePostData(){
        if(isset($_POST["cliente_nom"])){
            if(\Utilities\Validators::IsEmpty($_POST["cliente_nom"])){
                $this->viewData["has_errors"] = true;
                $this->viewData["cliente_nom_error"] = "El nombre no puede ir vacío!";
            }
        } else {
            throw new Exception("cliente_nom not present in form");
        }
        if(isset($_POST["cliente_gen"])){
            if (!in_array( $_POST["cliente_gen"], array("M","F"))){
                throw new Exception("cliente_gen incorrect value");
            }
        }else {
            if($this->viewData["mode"]!=="DEL") {
                throw new Exception("cliente_gen not present in form");
            }
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
        if(isset($_POST["clienteid"])){
            if(($this->viewData["mode"] !== "INS" && intval($_POST["clienteid"])<=0)){
                throw new Exception("clienteid is not Valid");
            }
            if($this->viewData["clienteid"]!== intval($_POST["clienteid"])){
                throw new Exception("clienteid value is different from query");
            }
        }else {
            throw new Exception("clienteid not present in form");
        }
        $this->viewData["cliente_nom"] = $_POST["cliente_nom"];
        $this->viewData["cliente_email"] = $_POST["cliente_email"];
        $this->viewData["cliente_telefono1"] = $_POST["cliente_telefono1"];
        if($this->viewData["mode"]!=="DEL"){
            $this->viewData["cliente_gen"] = $_POST["cliente_gen"];
        }
        $this->viewData["cliente_direccion"] = $_POST["cliente_direccion"];
        $this->viewData["cliente_telefono2"] = $_POST["cliente_telefono2"];

    }
    private function executeAction(){
        switch($this->viewData["mode"]){
            case "INS":
                $inserted = \Dao\Mnt\Clientes::insert(
                    $this->viewData["cliente_nom"],
                    $this->viewData["cliente_email"],
                    $this->viewData["cliente_telefono1"],
                    $this->viewData["cliente_gen"],
                    $this->viewData["cliente_direccion"], 
                    $this->viewData["cliente_telefono2"]
                    
                );
                if($inserted > 0){
                    \Utilities\Site::redirectToWithMsg(
                        $this->redirectTo,
                        "Cliente Creado Exitosamente"
                    );
                }
                break;
            case "UPD":
                $updated = \Dao\Mnt\Clientes::update(
                    $this->viewData["clienteid"], 
                    $this->viewData["cliente_nom"],
                    $this->viewData["cliente_email"],
                    $this->viewData["cliente_telefono1"],
                    $this->viewData["cliente_gen"],
                    $this->viewData["cliente_direccion"], 
                    $this->viewData["cliente_telefono2"]
                );
                if($updated > 0){
                    \Utilities\Site::redirectToWithMsg(
                        $this->redirectTo,
                        "Cliente Actualizada Exitosamente"
                    );
                }
                break;
            case "DEL":
                $deleted = \Dao\Mnt\Clientes::delete(
                    $this->viewData["clienteid"]
                );
                if($deleted > 0){
                    \Utilities\Site::redirectToWithMsg(
                        $this->redirectTo,
                        "Cliente Eliminado Exitosamente"
                    );
                }
                break;
        }
    }
    private function render(){
        if($this->viewData["mode"] === "INS") {
            $this->viewData["modedsc"] = $this->modes["INS"];
        } else {
            $tmpClientes = \Dao\Mnt\Clientes::findById($this->viewData["clienteid"]);
            if(!$tmpClientes){
                throw new Exception("Cliente no existe en DB");
            }
            
            \Utilities\ArrUtils::mergeFullArrayTo($tmpClientes, $this->viewData);
            $this->viewData["cliente_gen_M"] = $this->viewData["cliente_gen"] === "M" ? "selected": "";
            $this->viewData["cliente_gen_F"] = $this->viewData["cliente_gen"] === "F" ? "selected": ""; 
            $this->viewData["modedsc"] = sprintf(
                $this->modes[$this->viewData["mode"]],
                $this->viewData["clienteid"], 
                $this->viewData["cliente_nom"],
                $this->viewData["cliente_email"],
                $this->viewData["cliente_telefono1"],
                $this->viewData["cliente_gen"],
                $this->viewData["cliente_direccion"], 
                $this->viewData["cliente_telefono2"]
            );
            if(in_array($this->viewData["mode"], array("DSP","DEL"))){
                $this->viewData["readonly"] = "readonly";
            }
            if($this->viewData["mode"] === "DSP") {
                $this->viewData["show_action"] = false;
            }
        }
        Renderer::render("mnt/cliente", $this->viewData);
    }
}
?>