<?php

class HomeController {

    public function actionIndex() {
        require_once(Root.'/views/Home/index.php');
        return true;
    }

}