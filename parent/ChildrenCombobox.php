<?php

include '../inc/conf.php';

session_start();

function getChildrenCombobox($parentId) {

$parentId = $_SESSION['parentId'];

mysql_connect(DB_SERVER, DB_LOGIN, DB_PASS);

mysql_query('USE dn') or die('koniec use');

$result = mysql_query('SELECT id, imie FROM uczniowie WHERE id_opiekuna = ' . $parentId) or die('koniec select');

$markup = '<select id="childrenChoice">';
while(($row = mysql_fetch_row($result)) != ''){
	$markup .= '<option value="' . $row[0] . '">' . $row[1] . '</option>';
}
$markup .= '</select>';

return $markup;
}
?>