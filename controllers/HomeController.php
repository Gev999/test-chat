<?php

class HomeController {

    public function actionIndex() {
        if (isset($_SESSION['logged_in']) && $_SESSION['logged_in']) {
            header('Location: /user/page');
            exit(1);
        }
        require_once(Root.'/views/Home/index.php');
        return true;
    }

}