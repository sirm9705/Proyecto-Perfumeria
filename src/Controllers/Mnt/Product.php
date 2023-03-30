<?php
    namespace Controllers\Mnt;
    use Exception;
    use Controllers\PublicController;

    class Product extends PublicController{
        private $redirecTo = "index.php?page=Mnt-Product";
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
            "DELL" => "Borrar %s (%s)"
        );
        public function run(): void
        {
        }
    }
?>