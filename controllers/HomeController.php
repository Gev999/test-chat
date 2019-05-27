<?php

class HomeController {

    public function actionIndex() {
        if (isset($_SESSION['logged_in']) && $_SESSION['logged_in']) {
            header('Location: /user/page');
            
        }
        require_once(Root.'/views/Home/index.php');
        return true;
    }

    public function actionPageNotFound() {
        require_once(Root.'/views/Home/pageNotFound.php');
        return true;
    }
}