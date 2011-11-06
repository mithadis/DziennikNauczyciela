<?php

include 'inc/conf.php';

function checkCredentials($login, $password, $roleTableName){
	
	mysql_connect(DB_SERVER, DB_LOGIN, DB_PASS) or die('koniec connect');
	mysql_query('USE dn') or die('koniec use');
	
	$result = mysql_query('SELECT id FROM '. $roleTableName . ' WHERE login = \'' . $login . '\' AND haslo = \'' . $password .'\'') or die('koniec select');

	$row = mysql_fetch_row($result);
	mysql_close();

	return $row[0];
		
}

$login = $_POST['login'];
$pass = $_POST['password'];

//echo $login . '  '. $pass;
$id = checkCredentials($login, $pass, 'opiekunowie');
//echo 'id = ' . $id;
if($id != ""){
	session_start();
	$_SESSION['parentId'] = $id;
	include '/parent/logged.php';
	
}else{
	
	$id = checkCredentials($login, $pass, 'nauczyciele');
	
	if($id != ""){
		session_start();
		$_SESSION['teacherId'] = $id;
		include '/teacher/logged.php';		
		
	}else{
		
		include 'error.php';
		
	}

}




?>