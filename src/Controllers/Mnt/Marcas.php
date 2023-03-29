<?php
    namespace Controllers\Mnt;

use Controllers\PublicController;
use Views\Renderer;

    class Marcas extends PublicController{

    /**
     * Handles Categorias Request
     *
     * @return void
     */
        public function run(): void{
            $viewData = array(
                "edit_enabled"=>true,
                "delete_enabled"=>true,
                "new_enabled"=>true
            );
            $viewData ["marcas"] = \Dao\Mnt\Marcas::findAll();
            Renderer:: render('mnt/marcas', $viewData);
        }
    }
