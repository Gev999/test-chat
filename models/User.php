<?php
include_once Root . '/config/getDb.php';
date_default_timezone_set('Asia/Yerevan');

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
            return 'Account with this username already exists';
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
        $query = "INSERT INTO login VALUES(NULL, '$login', '$encPass')";
        mysqli_query($link, $query) or die('Error query' . mysqli_error($link));

        $query = "SELECT user_id FROM login WHERE username='$login' && password='$encPass'";
        $result = mysqli_query($link, $query) or die('Error query' . mysqli_error($link));
        self::addLoginDetails(mysqli_fetch_assoc($result));
        
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
        $query = "SELECT user_id FROM login WHERE username='$login' && password='$encPass'";
        $result = mysqli_query($link, $query) or die('Error query' . mysqli_error($link));
        if (mysqli_num_rows($result) == 0) {
            mysqli_close($link);
            return true;
        }
        self::addLoginDetails(mysqli_fetch_assoc($result));

        mysqli_close($link);
        return false;
    }

    public static function fetchUsers() {
        $link = getDb();
        //
        $query = "SELECT * FROM login WHERE user_id!='".$_SESSION['user_id']."'";
        $result = mysqli_query($link, $query) or die('Error query' . mysqli_error($link));

        $output = '
        <table class="table table-bordered table-striped">
        <tr>
        <td class="td-title">Username</td>
        <td class="td-title">Status</td>
        <td class="td-title">Action</td>
        </tr>
        ';

        while($row = mysqli_fetch_assoc($result)) {
            $status = '';
            $current_timestamp = strtotime(date("Y-m-d H:i:s") . '- 10 second');
            $current_timestamp = date('Y-m-d H:i:s', $current_timestamp);
            $user_last_activity = self::fetch_user_last_activity($row['user_id']);
            if($user_last_activity > $current_timestamp) {
                $status = '<span class="label label-success">Online</span>';
            }
            else {
                $status = '<span class="label label-danger">Offline</span>';
            }
            $output .= '
            <tr>
            <td>'.$row['username'].'</td>
            <td>'.$status.'</td>
            <td><button type="button" class="btn btn-info btn-xs start_chat" data-touserid="'.$row['user_id'].'" data-tousername="'.$row['username'].'">Start Chat</button></td>
            </tr>
            ';
        }

        $output .= '</table>';
        mysqli_close($link);

        return $output;
    }

    public static function updateLastActivity() {
        $link = getDB();
        
        $query = "
        UPDATE login_details 
        SET last_activity = now() 
        WHERE login_details_id = '".$_SESSION["login_details_id"]."'
        ";
        mysqli_query($link, $query) or die('Error query' . mysqli_error($link));
        mysqli_close($link);
    }

    public static function insertChat() {

        $to_user_id  = $_POST['to_user_id'];
        $from_user_id = $_SESSION['user_id'];
        $chat_message = $_POST['chat_message'];
        $status = '1';

        $link = getDb();
        
        $query = "
        INSERT INTO chat_message 
        (to_user_id, from_user_id, chat_message, status) 
        VALUES ('$to_user_id', '$from_user_id', '$chat_message', '$status')
        ";

        $result = mysqli_query($link, $query) or die('Error query' . mysqli_error($link));
        if ($result) {
            echo self::fetch_user_chat_history($_SESSION['user_id'], $_POST['to_user_id'], $link);
        }
        else {
            echo 'Fuck';
        }
        mysqli_close($link);
    }

    public static function fetch_user_chatHistory() {
        $connect = getDb();
        echo self::fetch_user_chat_history($_SESSION['user_id'], $_POST['to_user_id'], $connect);
    }

    //private functions

    private static function isExistLog($login) {
        $link = getDb();
        $query = "SELECT user_id FROM login WHERE username='$login'";
        $result = mysqli_query($link, $query) or die('Error query' . mysqli_error($link));
        if (mysqli_num_rows($result) > 0) {
            return true;
        }
        else {
            return false;
        }
        mysqli_close($link);
    }

    private static function addLoginDetails($row) {
        $link = getDb();
        
        $data = $row['user_id'];
        $_SESSION['user_id'] = $data;
        $query = "INSERT INTO login_details (user_id) VALUES('$data')";
        mysqli_query($link, $query) or die('Error query' . mysqli_error($link));
        $_SESSION['login_details_id'] = mysqli_insert_id($link);
        mysqli_close($link);
    }

    private static function fetch_user_last_activity($user_id) {
        $link = getDb();
        
        $query = "
        SELECT * FROM login_details 
        WHERE user_id = '$user_id' 
        ORDER BY last_activity DESC 
        LIMIT 1
        ";

        $result = mysqli_query($link, $query) or die('Error query' . mysqli_error($link));
        while($row = mysqli_fetch_assoc($result)) {
            return $row['last_activity'];
        }
    }

    private static function fetch_user_chat_history($from_user_id, $to_user_id, $connect) {
        $query = "
        SELECT * FROM chat_message 
        WHERE (from_user_id = '".$from_user_id."' 
        AND to_user_id = '".$to_user_id."') 
        OR (from_user_id = '".$to_user_id."' 
        AND to_user_id = '".$from_user_id."') 
        ORDER BY timestamp DESC
        ";

        $result = mysqli_query($connect, $query) or die('Error query' . mysqli_error($connect));
        $output = '<ul class="list-unstyled">';
        while($row = mysqli_fetch_assoc($result)) {
            $user_name = '';
            if($row["from_user_id"] == $from_user_id) {
                $user_name = '<b class="text-success">You</b>';
            }
            else {
                $user_name = '<b class="text-danger">'.self::get_user_name($row['from_user_id'], $connect).'</b>';
            }
            $output .= '
            <li style="border-bottom:1px dotted #ccc">
            <p>'.$user_name.' - '.$row["chat_message"].'
                <div align="right">
                - <small><em>'.$row['timestamp'].'</em></small>
                </div>
            </p>
            </li>
            ';
        }
        $output .= '</ul>';
        return $output;
    }

    private static function get_user_name($user_id, $connect) {
        $query = "SELECT username FROM login WHERE user_id = '$user_id'";
        $result = mysqli_query($connect, $query) or die('Error query' . mysqli_error($connect));
        while($row = mysqli_fetch_assoc($result)) {
            return $row['username'];
        }
    }

}