<?php
    namespace Controllers\Mnt;
    use Exception;
    use Controllers\PublicController;
    use Views\Renderer;

    class Product extends PublicController{
        private $redirecTo = "index.php?page=Mnt-Products";
        private $viewData = array(
            "mode"=>"DSP",
            "modedsc"=>"",
            "idproducto" => 0,
            "nom_prod" => "",
            "desc_prod" => "",
            "precio" => "",
            "idmarca" => "",
            "fecha_vencimiento" => "",
            "img" => "",
            "nom_prod_errors" => "",
            "precio_errors" => "",
            "general_error"=>array(),
            "has_errors"=>false,
            "show_action" => true,
            "readonly"=>false
        );
        private $modes = array(
            "DISP" => "Detalle de %s (%s)",
            "INS" => "Nuevo Cliente",
            "UPD" => "Editar %s (%s)",
            "DEL" => "Borrar %s (%s)"
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
                    sprintf("Controller/Mnt/Product ERROR: %s",$error->getMessage(\Utilities\Site::redirectToWithMsg(
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
                if(isset($_GET['cidproducto'])){
                    $this->viewData["idproducto"]=intval($_GET["idproducto"]);
                }else{
                    throw  new Exception("Id not Found on Query Params");
                }
            }
        }
        private function validatePostData()
        {
            if(isset($_POST["nom_prod"]))
            {
                if(\Utilities\Validators::IsEmpty($_POST["nom_prod"])){
                    $this->viewData["has_errors"]=true;
                    $this->viewData["nom_prod_error"]="El Nombre no puede ir vacio";
                }
            }else{
                throw new Exception("nom_prod not present in form");
            }
            if(isset($_POST["precio"])){
                if(\Utilities\Validators::IsEmpty($_POST["precio"])){
                    $this->viewData["has_errors"]=true;
                    $this->viewData["nprecio_error"]="El precio no puede ir vacio";
                }
            }else{
                throw new Exception("precio not present in form");
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
            if(isset($_POST["idproducto"])){
                if(!($this->viewData["idproducto"] !=="INS" && intval($_POST["idproducto"])>0)){
                    throw new Exception("idproducto is not Valid");
                }
                if($this->viewData["idproducto"] !== $_POST["idproducto"]){
                    throw new Exception("idproducto value is different from query");
                }
            }else{
                throw new Exception("idproducto not present in form");
            }
            $this->viewData["idproducto"]=$_POST["idproducto"];
            $this->viewData["nom_prod"]=$_POST["nom_prod"];
            $this->viewData["desc_prod"]=$_POST["desc_prod"];
            $this->viewData["precio"]=$_POST["precio"];
            $this->viewData["idmarca"]=$_POST["idmarca"];
            $this->viewData["fecha_vencimiento"]=$_POST["fecha_vencimiento"];
            $this->viewData["img"]=$_POST["img"];
        }
        private function executeAction()
        {
            switch($this->viewData["mode"]){
                case "INS";
                    $inserted=\Dao\Mnt\Products::insert(
                        $this->viewData["nom_prod"],
                        $this->viewData["desc_prod"],
                        $this->viewData["precio"],
                        $this->viewData["idmarca"],
                        $this->viewData["fecha_vencimiento"],
                        $this->viewData["img"]

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
                        $this->viewData["idproducto"],
                        $this->viewData["nom_prod"],
                        $this->viewData["desc_prod"],
                        $this->viewData["precio"],
                        $this->viewData["idmarca"],
                        $this->viewData["fecha_vencimiento"],
                        $this->viewData["img"]
                    );
                    if($updated>0){
                        \Utilities\Site::redirectToWithMsg(
                            $this->redirecTo,
                            "Producto actualizadoo Existosamente"
                        );
                    }
                    break;
                case "DEL";
                    $delete=\Dao\Mnt\Products::delete(
                        $this->viewData["idproducto"]
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
                $tmpProducts=\Dao\Mnt\Products::findById(
                    $this->viewData["idproducto"]
                );
                if(!$tmpProducts){
                    throw new Exception("Producto no existente en BD");
                }
                \Utilities\ArrUtils::mergeFullArrayTo(
                    $tmpProducts,
                    $this->viewData
                );
                $this->viewData["modesdsc"]=sprintf(
                    $this->viewData["idproducto"],
                    $this->viewData["nom_prod"],
                    $this->viewData["desc_prod"],
                    $this->viewData["precio"],
                    $this->viewData["idmarca"],
                    $this->viewData["fecha_vencimiento"],
                    $this->viewData["img"]
                );
                if (in_array($this->viewData["mode"],array("DSP","DEL"))){
                    $this->viewData["readonly"]=true;
                }
                if($this->viewData["mode"]=="DSP"){
                    $this->viewData["show_action"]=false;
                }
            }
            Renderer::render("mnt/product",$this->viewData);
        }
    }
?>