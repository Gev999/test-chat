<?php

include_once Root . '/config/db_params.php';

function getDb() {
	$params = array();
	$params = getDbParams();
	$host = $params['host'];
	$dbname = $params['dbname'];
	$user = $params['user'];
	$password = $params['password'];
	$link = mysqli_connect($host, $user, $password, $dbname);
	return $link;
}