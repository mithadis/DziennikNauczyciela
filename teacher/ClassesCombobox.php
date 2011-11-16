<?php

require_once '../inc/conf.php';

session_start();

function getClassesCombobox($teacherId, $classId = '') {
	initDB();
	$teacherId = $_SESSION['teacherId'];
	$classId = $_SESSION['classId'];

	$q = 'SELECT DISTINCT id_klasy, CONCAT(rok, "-\"",grupa,"\"", CASE kl.id_wychowawcy WHEN 30 THEN " (W) " ELSE "" END) as nazwa ';
	$q.= ' FROM klasy kl JOIN kursy ku ON kl.id = ku.id_klasy WHERE ku.id_nauczyciela = '. $teacherId . ' order by nazwa';
	
	$result = mysql_query($q) or die('koniec select');

	$markup = '<select id="classChoice">';
	while(($row = mysql_fetch_row($result)) != ''){
		if($classId == ''){
			$classId = $row[0];
			$_SESSION['classId'] = $classId;		
		}
		$markup .= '<option value="' . $row[0] . '"'. select($row[0], $classId) . '>' . $row[1] . '</option>';
	}
	$markup .= '</select>';

	return $markup;
}

function select($currentClassValue, $classId){

	if(!empty($classId)){

		if($currentClassValue == $classId){
			return ' selected="selected" ';
		}
	}

}

?>