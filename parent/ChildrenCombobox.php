<?php

require_once '../inc/conf.php';

session_start();

function getChildrenCombobox($parentId, $childId = '') {

$parentId = $_SESSION['parentId'];
$childId = $_SESSION['childId'];

initDB();
$result = mysql_query('SELECT id, imie FROM uczniowie WHERE id_opiekuna = ' . $parentId) or die('koniec select');

$markup = '<select id="childrenChoice">';
while(($row = mysql_fetch_row($result)) != ''){
	$markup .= '<option value="' . $row[0] . '"'. select($row[0], $childId) . '>' . $row[1] . '</option>';
}
$markup .= '</select>';

return $markup;
}

function select($currentChildValue, $childId){

	if(!empty($childId)){
		
		if($currentChildValue == $childId){
			return ' selected="selected" ';
		}
	}
	
}


?>