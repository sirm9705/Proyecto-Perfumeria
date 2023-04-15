<?php
namespace Controllers\Mnt;

use Controllers\PublicController;
use Exception;
use Views\Renderer;

class Stock extends PublicController
{

    private $redirectTo = "index.php?page=Mnt-Stocks";
    private $viewData = array(
        "mode" => "DSP",
        "modedsc" => "",
        "idstock" => 0,
        "cantidad" => "",
        "estado" => "ACT",
        "estado_ACT" => "selected",
        "estado_INA" => "",
        "idproducto" => "",
        "cantidad_errror" => "",
        "idproducto_errors" => "",
        "general_errors" => array(),
        "has_errors" => false,
        "show_action" => true,
        "readonly" => false,
        "xssToken" => ""
    );

    private $modes = array(
        "DSP" => "Detalle de %s (%s)",
        "INS" => "Nuevo Stock",
        "UPD" => "Editar %s (%s)",
        "DEL" => "Borrar %s (%s)"
    );

    public function run(): void
    {
        try {
            $this->page_loaded();
            if ($this->isPostBack()) {
                $this->validatePostData();
                if(!$this->viewData["has_errors"]){
                    $this->executeAction();
                }
            }
            $this->render();
        } catch (Exception $error) {
            error_log(
                sprintf("Controller/Mnt/Stock ERROR: %s", $error->getMessage(\Utilities\Site::redirectToWithMsg(
                    $this->redirectTo,
                    "Algo Inesperado Sucedio. Intente de Nuevo"
                )))
            );
        }
    }

    private function page_loaded()
    {
        if (isset($_GET['mode'])) {
            if (isset($this->modes[$_GET['mode']])) {
                $this->viewData["mode"] = $_GET['mode'];
            } else {
                throw new Exception("Mode not available");
            }
        } else {
            throw new Exception("Mode not defined on Query Params");
        }
        if ($this->viewData["mode"] !== "INS") {
            if (isset($_GET['idstock'])) {
                $this->viewData['idstock'] = intval($_GET['idstock']);
            } else {
                throw  new Exception("Id not Found on Query Params");
            }
        }
    }

    private function validatePostData()
    {
        if (isset($_POST["cantidad"])) {
            if (\Utilities\Validators::IsEmpty($_POST["cantidad"])) {
                $this->viewData["has_errors"] = true;
                $this->viewData["cantidad_error"] = "Cantidad no puede ir vacia";
            }
        } else {
            throw new Exception("cantidad not present in form");
        }

        if (isset($_POST["idproducto"])) {
            if (\Utilities\Validators::IsEmpty($_POST["idproducto"])) {
                $this->viewData["has_errors"] = true;
                $this->viewData["idproducto_error"] = "El id de Producto no puede ir vacio";
            }
        } else {
            throw new Exception("idproducto not present in form");
        }

        if (isset($_POST["mode"])) {
            if (!key_exists($_POST["mode"], $this->modes)) {
                throw new Exception("mode has a bad value");
            }
            if ($this->viewData["mode"] !== $_POST["mode"]) {
                throw new Exception("mode value is different from query");
            }
        } else {
            throw new Exception("mode not present in form");
        }

        if (isset($_POST["idstock"])) {
            if (!($this->viewData["idstock"] !== "INS" && intval($_POST["idstock"]) > 0)) {
                throw new Exception("idstock is not Valid");
            }
            if ($this->viewData["idstock"] !== $_POST["idstock"]) {
                throw new Exception("idstock value is different from query");
            }
        } else {
            throw new Exception("idstock not present in form");
        }

        $this->viewData["idstock"] = $_POST["idstock"];
        $this->viewData["cantidad"] = $_POST["cantidad"];
        $this->viewData["idproducto"] = $_POST["idproducto"];

        if ($this->viewData["mode"] !== "DEL") {
            $this->viewData["estado"] = $_POST["estado"];
        }
    }

    private function executeAction(){
        switch($this->viewData["mode"]){
        case "INS":
            $inserted=\Dao\Mnt\Stocks::insert(
                $this->viewData["cantidad"],
                $this->viewData["estado"],
                $this->viewData["idproducto"]
            );
            if($inserted>0){
                \Utilities\Site::redirectToWithMsg(
                    $this->redirectTo,
                    "Stock Creado Existosamente"
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
            $delete = \Dao\Mnt\Stocks::delete(
                $this->viewData["idstock"]
            );
            if($delete>0){
                \Utilities\Site::redirectToWithMsg(
                    $this->redirectTo,
                    "Stock eliminado Existosamente"
                );
            }
            break;
        }
    }

    private function render(){
        if($this->viewData["mode"]=="INS"){
            $this->viewData["modedsc"] = $this->modes["INS"];
        } else {
            $tmpStocks = \Dao\Mnt\Stocks::findById(
                $this->viewData["idstock"]
            );
            if(!$tmpStocks){
                throw new Exception("Stock no existente en BD");
            }

            \Utilities\ArrUtils::mergeFullArrayTo($tmpStocks,$this->viewData);
            $this->viewData["estado_ACT"] = $this->viewData["estado"] === "ACT" ? "selected": "";
            $this->viewData["estado_INA"] = $this->viewData["estado"] === "INA" ? "selected": "";
            $this->viewData["modedsc"] = sprintf(
                $this->modes[$this->viewData["mode"]],
                $this->viewData["idstock"],
                $this->viewData["cantidad"],
                $this->viewData["idproducto"]     
            );

            if (in_array($this->viewData["mode"],array("DSP","DEL"))){
                $this->viewData["readonly"]=true;
            }
            if($this->viewData["mode"]=="DSP"){
                $this->viewData["show_action"]=false;
            }
        }
        Renderer::render("mnt/stock", $this->viewData);
    }
}
