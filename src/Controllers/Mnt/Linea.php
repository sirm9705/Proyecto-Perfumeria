<?php
    namespace Controllers\Mnt;
    use Exception;
    use Controllers\PublicController;
    use Views\Renderer;

    class Product extends PublicController{
        private $redirecTo = "index.php?page=Mnt-Product";
        private $viewData = array(
            "mode"=>"DSP",
            "modedsc"=>"",
            "idlinea" => 0,
            "tipo_linea" => "",
            "nom_prod_errors" => "",
            "general_error"=>array(),
            "has_errors"=>false,
            "show_action" => true,
            "readonly"=>false
        );
        private $modes = array(
            "DISP" => "Detalle de %s (%s)",
            "INS" => "Nuevo Cliente",
            "UPD" => "Editar %s (%s)",
            "DELL" => "Borrar %s (%s)"
        );
        public function run(): void
        {
            try{
                $this->page_loaded();
                if($this->isPostBack())
                {
                    $this->validatePostData();
                    if($this->viewData["has_errors"])
                    {
                        $this->executeAction();
                    }
                }
                $this->render();
            }
            catch(Exception $error){
                error_log(
                    sprintf("Controller/Mnt/Linea ERROR: %s",$error->getMessage(\Utilities\Site::redirectToWithMsg(
                        $this->redirecTo,"Algo Inesperado Sucedio. Intente de Nuevo"
                    )))
                );
            }
        }
        private function page_loaded()
        {
            if(isset($_GET['mode'])){
                if(isset($this->modes[$_GET['mode']])){
                    $this->viewData["mode"]=$_GET['mode'];
                }
                else{
                    throw new Exception("Mode not available");
                }
            }
            else{
                throw new Exception("Mode not defined on Query Params");
            }
            if($this->viewData["mode"] !== "INS")
            {
                if(isset($_GET['cidlinea'])){
                    $this->viewData["idlinea"]=intval($_GET["idlinea"]);
                }else{
                    throw  new Exception("Id not Found on Query Params");
                }
            }
        }
        private function validatePostData()
        {
            if(isset($_POST["tipo_linea"]))
            {
                if(\Utilities\Validators::IsEmpty($_POST["tipo_id"])){
                    $this->viewData["has_errors"]=true;
                    $this->viewData["nom_prod_error"]="El Nombre no puede ir vacio";
                }
            }else{
                throw new Exception("tipo_linea not present in form");
            }

            if(isset($_POST["mode"])){
                if(! key_exists($_POST["mode"],$this->modes)){
                    throw new Exception("mode has a bad value");
                }
                if($this->viewData["mode"] !== $_POST["mode"]){
                    throw new Exception("mode value is different from query");
                }
            }else{
                throw new Exception("mode not present in form");
            }
            if(isset($_POST["idlinea"])){
                if(!($this->viewData["idlinea"] !=="INS" && intval($_POST["idlinea"])>0)){
                    throw new Exception("idlinea is not Valid");
                }
                if($this->viewData["idlinea"] !== $_POST["idlinea"]){
                    throw new Exception("idlinea value is different from query");
                }
            }else{
                throw new Exception("idlinea not present in form");
            }
            $this->viewData["idlinea"]=$_POST["idlinea"];
            $this->viewData["tipo_linea"]=$_POST["tipo_linea"];
        }
        private function executeAction()
        {
            switch($this->viewData["mode"]){
                case "INS";
                    $inserted=\Dao\Mnt\Products::insert(
                        $this->viewData["tipo_linea"]
                    );
                    if($inserted>0){
                        \Utilities\Site::redirectToWithMsg(
                            $this->redirecTo,
                            "Producto Creado Existosamente"
                        );
                    }
                    break;
                case "UPD";
                    $updated=\Dao\Mnt\Products::update(
                        $this->viewData["idlinea"],
                        $this->viewData["tipo_linea"]
                    );
                    if($updated>0){
                        \Utilities\Site::redirectToWithMsg(
                            $this->redirecTo,
                            "Producto actualizadoo Existosamente"
                        );
                    }
                    break;
                case "DELL";
                    $delete=\Dao\Mnt\Linea::delete(
                        $this->viewData["idlinea"]
                    );
                    if($delete>0){
                        \Utilities\Site::redirectToWithMsg(
                            $this->redirecTo,
                            "Producto eliminado Existosamente"
                        );
                    }
                    break;
            }
        }
        private function render()
        {
            if($this->viewData["mode"]=="INS"){
                $this->viewData["modedsc"]=$this->modes["INS"];
            }
            else{
                $tmpProducts=\Dao\Mnt\Linea::findById(
                    $this->viewData["idlinea"]
                );
                if(!$tmpProducts){
                    throw new Exception("Producto no existente en BD");
                }
                \Utilities\ArrUtils::mergeFullArrayTo(
                    $tmpProducts,
                    $this->viewData
                );
                $this->viewData["modesdsc"]=sprintf(
                    $this->viewData["idlinea"],
                    $this->viewData["tipo_linea"]
                );
                if (in_array($this->viewData["mode"],array("DSP","DEL"))){
                    $this->viewData["readonly"]=true;
                }
                if($this->viewData["mode"]=="DSP"){
                    $this->viewData["show_action"]=false;
                }
            }
            Renderer::render("mnt/linea",$this->viewData);
        }
    }
?>