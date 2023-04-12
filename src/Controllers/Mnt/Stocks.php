<?php
/**

 */
namespace Controllers\Mnt;

use Controllers\PublicController;
use Views\Renderer;

/**
 * Stocks
 */
class Stocks extends PublicController {
    /**
     * Handles Stocks Request
     *
     * @return void
     */
    public function run() :void
    {
        $viewData = array(
            "edit_enabled"=>true,
            "delete_enabled"=>true,
            "new_enabled"=>true
        );
        $viewData["stocks"] = \Dao\Mnt\Stocks::findAll();
        Renderer::render('mnt/stocks', $viewData);
    }
}
?>