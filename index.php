<?php
session_start();
//Front Controller

ini_set('display_errors', 1);
error_reporting(E_ALL);

define('Root', dirname('_FILE_'));
require_once(Root.'/components/Autoload.php');
$route = new Router;
$route -> run();