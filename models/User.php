<?php
include_once Root . '/config/getDb.php';

class User {

    public static function checkLogin(&$login) {
        $login = htmlentities(trim($_POST['login']));
        if ($login == '') {
            return 'Please fill in the field';
        }
        if (strlen($login) < 6) {
            return 'The count of chars must be more than 5';
        } 
        if (self::isExistLog($login)) {
            return 'Account with this login already exists';
        }
        return '';
    }

    public static function checkPass(&$pass) {
        $pass = htmlentities(trim($_POST['password']));
        if ($pass == '') {
            return 'Please fill in the field';
        }
        if (strlen($pass) < 8) {
            return 'The count of chars must be more than 8';
        } 
        return '';
    }

    public static function registerData($login, $pass) {
        $link = getDb();
        $encPass = md5($pass);
        $query = "INSERT INTO users VALUES(NULL, '$login', '$encPass')";
        mysqli_query($link, $query) or die('Error query' . mysqli_error($link));
        mysqli_close($link);
    }

    public static function checkUserData(&$login, &$pass) {
        $login = htmlentities(trim($_POST['login']));
        $pass = htmlentities(trim($_POST['password']));
        if ($login=='' || $pass=='') {
            return true;
        }
        $link = getDb();
        $encPass = md5($pass);
        $query = "SELECT user_id FROM users WHERE user_login='$login' && user_pass='$encPass'";
        $result = mysqli_query($link, $query) or die('Error query' . mysqli_error($link));
        if (mysqli_num_rows($result) == 0) {
            mysqli_close($link);
            return true;
        }
        mysqli_close($link);
        return false;
    }

    //private functions

    private static function isExistLog($login) {
        $link = getDb();
        $query = "SELECT user_id FROM users WHERE user_login='$login'";
        $result = mysqli_query($link, $query) or die('Error query' . mysqli_error($link));
        if (mysqli_num_rows($result) > 0) {
            return true;
        }
        else {
            return false;
        }
        mysqli_close($link);
    }

}