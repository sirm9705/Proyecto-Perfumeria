<?php
namespace Controllers\Mnt;

use Controllers\PublicController;
use Views\Renderer;

class Lineas extends PublicController {
    public function run() :void
    {
        $viewData = array(
            "edit_enabled"=>true,
            "delete_enabled"=>true,
            "new_enabled"=>true
        );
        $viewData["lineas"] = \Dao\Mnt\Lineas::findAll();
        Renderer::render('mnt/lineas', $viewData);}
}
?>