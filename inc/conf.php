<?php

define('DB_SERVER', 'localhost:3306');
define('DB_LOGIN', 'root');
define('DB_PASS', 'root');


function initDB(){
	mysql_connect(DB_SERVER, DB_LOGIN, DB_PASS);
	mysql_query('USE dn') or die('koniec use');
}

?>