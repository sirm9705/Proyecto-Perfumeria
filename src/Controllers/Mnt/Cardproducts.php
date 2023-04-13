<?php
    namespace Controllers\Mnt;

use Controllers\PublicController;
use Dao\Dao;
use Views\Renderer;

    class Cardproducts extends PublicController{
        public function run(): void
        {
            $viewData = array();
            $viewData["cardproducts"] = \Dao\Mnt\Products::findAll();
            Renderer::render("mnt\cardproducts",$viewData);
        }
    }
?>