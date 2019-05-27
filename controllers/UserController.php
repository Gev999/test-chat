<?php

class UserController {

    public function actionPage() {
        if (isset($_SESSION['logged_in']) && $_SESSION['logged_in']) {
            require_once(Root.'/views/User/page.php');
        }
        else {
            header('Location: /');
            
        }
        return true;
    }

    public function actionRegister() {
        if (isset($_SESSION['logged_in']) && $_SESSION['logged_in']) {
            header('Location: /user/page');
            
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
                $_SESSION['username'] = $login;
                header('Location: /user/page');
                
            }
        }
        require_once(Root.'/views/User/register.php');
        return true;
    }

    public function actionSignin() {
        if (isset($_SESSION['logged_in']) && $_SESSION['logged_in']) {
            header('Location: /user/page');
            
        }
        $hasErr = false;
        $login = '';
        $pass='';
        if (isset($_POST['sign_in'])) {
            $hasErr = User::checkUserData($login, $pass);
            if ($hasErr==false) {
                $_SESSION['logged_in'] = true;
                $_SESSION['username'] = $login;
                header('Location: /user/page');
            }
        }
        require_once(Root.'/views/Home/index.php');
        return true;
    }

    public function actionLogout() {
        session_destroy();
        header('Location: /'); 
    }

    public function actionFetchUser() {
        echo User::fetchUsers();
        return true;
    }

    public function actionUpdateLastActivity() {
        User::updateLastActivity();
        return true;
    }

    public function actionInsertChat() {
        User::insertChat();
        return true;
    }

    public function actionFetchUser_chat_history() {
        User::fetch_user_chatHistory();
        return true;
    }

}