<?php
    namespace Controllers\Mnt;

use Controllers\PublicController;
use Dao\Dao;
use Views\Renderer;

    class Products extends PublicController{
        public function run(): void
        {
            $viewData = array();
            $viewData["products"] = \Dao\Mnt\Products::findAll();
            Renderer::render("mnt\products",$viewData);
        }
    }
?>