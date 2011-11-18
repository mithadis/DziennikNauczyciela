<?php

require_once '../inc/conf.php';

function getSubjectsList(){
	initDB();
	session_start();
	
	$teacherId = $_SESSION['teacherId'];
	$classId = $_SESSION['classId'];
	
	$q = 'SELECT przedmiot, id from kursy where id_nauczyciela = '. $teacherId . ' and id_klasy = '.$classId . ' ORDER BY przedmiot';
	$result = mysql_query($q);
	
	$markup = '';
	while(($row = mysql_fetch_row($result)) != ''){
	
		$markup.= '<li><a href="/DziennikNauczyciela/teacher/registerpage.php?courseId='.$row[1].'">'.$row[0].'</a></li>';
		
	}
	
	
	return $markup;
}

?>