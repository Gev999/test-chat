<?php

class UserController {

    public function actionPage() {
        if (isset($_SESSION['logged_in']) && $_SESSION['logged_in']) {
            require_once(Root.'/views/User/page.php');
        }
        else {
            header('Location: /');
            exit(1);
        }
        return true;
    }

    public function actionRegister() {
        if (isset($_SESSION['logged_in']) && $_SESSION['logged_in']) {
            header('Location: /user/page');
            exit(1);
        }
        $hasErr = false;
        $login='';
        $pass='';
        if (isset($_POST['register'])) {
            $nameErr = User::checkLogin($login);
            $passErr = User::checkPass($pass);
            if ($nameErr || $passErr) {
                $hasErr = true;
            }
            else {
                User::registerData($login, $pass);
            }

            if ($hasErr==false) {
                $_SESSION['logged_in'] = true;
                header('Location: /user/page');
                exit(1);
            }
        }
        require_once(Root.'/views/User/register.php');
        return true;
    }

    public function actionSignin() {
        if (isset($_SESSION['logged_in']) && $_SESSION['logged_in']) {
            header('Location: /user/page');
            exit(1);
        }
        $hasErr = false;
        $login = '';
        $pass='';
        if (isset($_POST['sign_in'])) {
            $hasErr = User::checkUserData($login, $pass);
            if ($hasErr==false) {
                $_SESSION['logged_in'] = true;
                header('Location: /user/page');
            }
        }
        require_once(Root.'/views/Home/index.php');
        return true;
    }

    public function actionLogout() {
        if (isset($_SESSION['logged_in']) && $_SESSION['logged_in']) {
            $_SESSION['logged_in'] = false;
        }
        header('Location: /');
        exit(1);
    }
}