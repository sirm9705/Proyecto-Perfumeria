<?php
namespace Controllers\Mnt;

use Controllers\PublicController;
use Exception;
use Views\Renderer;

class Stock extends PublicController{
    private $redirectTo = "index.php?page=Mnt-Stocks";
    private $viewData = array(
        "mode" => "DSP",
        "modedsc" => "",
        "idstock" => 0,
        "cantidad" => "",
        "idproducto" => "",
        "cantidad_error"=> "",
        "estado" => "ACT",
        "estado_ACT" => "selected",
        "estado_INA" => "",
        "general_errors"=> array(),
        "has_errors" =>false,
        "show_action" => true,
        "readonly" => false,
        "xssToken" =>""
    );
    private $modes = array(
        "DSP" => "Detalle de %s (%s)",
        "INS" => "Nuevo Stock",
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
            unset($_SESSION["xssToken_Mnt_Stock"]);
            error_log(sprintf("Controller/Mnt/Stock ERROR: %s", $error->getMessage()));
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
            if(isset($_GET['idstock'])){
                $this->viewData["idstock"] = intval($_GET["idstock"]);
            } else {
                throw new Exception("Id not found on Query Params");
            }
        }
    }
    private function validatePostData(){
        if(isset($_POST["xssToken"])){
            if(isset($_SESSION["xssToken_Mnt_Stock"])){
                if($_POST["xssToken"] !== $_SESSION["xssToken_Mnt_Stock"]){
                    throw new Exception("Invalid Xss Token no match");
                }
            } else {
                throw new Exception("Invalid Xss Token on Session");
            }
        } else {
            throw new Exception("Invalid Xss Token");
        }
        if(isset($_POST["cantidad"])){
            if(\Utilities\Validators::IsEmpty($_POST["cantidad"])){
                $this->viewData["has_errors"] = true;
                $this->viewData["cantidad_error"] = "La cantidad no puede ir vacío!";
            }
        } else {
            throw new Exception("Cantidad not present in form");
        }
        if(isset($_POST["estado"])){
            if (!in_array( $_POST["estado"], array("ACT","INA"))){
                throw new Exception("estado incorrect value");
            }
        }else {
            if($this->viewData["mode"]!=="DEL") {
                throw new Exception("Estado not present in form");
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
        if(isset($_POST["catid"])){
            if(($this->viewData["mode"] !== "INS" && intval($_POST["idstock"])<=0)){
                throw new Exception("idstock is not Valid");
            }
            if($this->viewData["idstock"]!== intval($_POST["idstock"])){
                throw new Exception("idstock value is different from query");
            }
        }else {
            throw new Exception("idstock not present in form");
        }
        $this->viewData["cantidad"] = $_POST["cantidad"];
        if($this->viewData["mode"]!=="DEL"){
            $this->viewData["estado"] = $_POST["estado"];
        }
    }
    private function executeAction(){
        switch($this->viewData["mode"]){
            case "INS":
                $inserted = \Dao\Mnt\Stocks::insert(
                    $this->viewData["cantidad"],
                    $this->viewData["estado"],
                    $this->viewData["idproducto"]
                );
                if($inserted > 0){
                    \Utilities\Site::redirectToWithMsg(
                        $this->redirectTo,
                        "Stock Creado Exitosamente"
                    );
                }
                break;
            case "UPD":
                $updated = \Dao\Mnt\Stocks::update(
                    $this->viewData["cantidad"],
                    $this->viewData["estado"],
                    $this->viewData["idproducto"],
                    $this->viewData["idstock"]
                );
                if($updated > 0){
                    \Utilities\Site::redirectToWithMsg(
                        $this->redirectTo,
                        "Stock Actualizado Exitosamente"
                    );
                }
                break;
            case "DEL":
                $deleted = \Dao\Mnt\Stocks::delete(
                    $this->viewData["idstock"]
                );
                if($deleted > 0){
                    \Utilities\Site::redirectToWithMsg(
                        $this->redirectTo,
                        "Stock Eliminado Exitosamente"
                    );
                }
                break;
        }
    }
    private function render(){
        $xssToken = md5("STOCK" . rand(0,4000) * rand(5000, 9999));
        $this->viewData["xssToken"] = $xssToken;
        $_SESSION["xssToken_Mnt_Stock"] = $xssToken;

        if($this->viewData["mode"] === "INS") {
            $this->viewData["modedsc"] = $this->modes["INS"];
        } else {
            $tmpStocks = \Dao\Mnt\Stocks::findById($this->viewData["idstock"]);
            if(!$tmpStocks){
                throw new Exception("Stock no existe en DB");
            }

            \Utilities\ArrUtils::mergeFullArrayTo($tmpStocks, $this->viewData);
            $this->viewData["estado_ACT"] = $this->viewData["estado"] === "ACT" ? "selected": "";
            $this->viewData["estado_INA"] = $this->viewData["estado"] === "INA" ? "selected": "";
            $this->viewData["modedsc"] = sprintf(
                $this->modes[$this->viewData["mode"]],
                $this->viewData["cantidad"],
                $this->viewData["catid"]
            );
            if(in_array($this->viewData["mode"], array("DSP","DEL"))){
                $this->viewData["readonly"] = "readonly";
            }
            if($this->viewData["mode"] === "DSP") {
                $this->viewData["show_action"] = false;
            }
        }
        Renderer::render("mnt/Stock", $this->viewData);
    }
}

?>