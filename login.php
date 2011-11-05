<?php

include 'inc/conf.php';

function checkCredentials($login, $password, $roleTableName){
	
	mysql_connect(DB_SERVER, DB_LOGIN, DB_PASS);
	mysql_query('USE dn');
	
	$result = mysql_query('SELECT id FROM '. $roleTableName . ' WHERE login = \'' . $login . '\' AND haslo = \'' . $password .'\'');

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

	$id = checkCredentials($login, $password, 'nauczyciele');
	
	if($id != ""){
		session_start();
		$_SESSION['teacherId'] = $id;
		include '/teacher/logged.php';		
		
	}else{
		
		include 'error.php';
		
	}

}




?>