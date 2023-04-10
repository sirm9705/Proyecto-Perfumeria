<?php
    namespace Controllers\Mnt;

use Controllers\PublicController;
use Dao\Dao;
use Views\Renderer;

    class Lineas extends PublicController{
        public function run(): void
        {
            $viewData = array();
            $viewData["lineas"] = \Dao\Mnt\Lineas::findAll();
            Renderer::render("mnt\lineas",$viewData);
        }
    }
?>