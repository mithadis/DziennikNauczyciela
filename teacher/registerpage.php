<?php

require_once '../inc/conf.php';
include '../inc/Template.php';
include '../inc/table.php';
include 'ClassesCombobox.php';
include 'SubjectsList.php';

session_start();

$courseId = $_GET['courseId'];
$classId = $_SESSION['classId'];
$teacherId = $_SESSION['teacherId'];

$classesCombo = getClassesCombobox($teacherId);
$subjectsList = getSubjectsList();

$pupilsTable = getPupilsTable($classId, $courseId);

$tl = new Template('../tls/teacher/index.html');
$tl->add('content', $pupilsTable);
$tl->add('classCombobox', $classesCombo);
$tl->add('subjectsList', $subjectsList);

echo $tl->execute();


function getPupilsTable($classId, $courseId){
	
	initDB();
	
	$q = 'SELECT CONCAT(nazwisko, " ", imie) as Nazwisko, id FROM uczniowie WHERE id_klasy = ' . $classId . ' ORDER BY Nazwisko';
	
	$result = mysql_query($q);
	
	$i = 0;
	$markup = '<table><thead><td>Nazwisko</td><td>Obecnoœæ</td><td>Oceny</td></thead><tbody>';
	while(($row = mysql_fetch_array($result)) != ''){
		$markup.='<tr class="'.oddEven($i).'" id="'.$row['id'].'"><td>'.$row['Nazwisko'].'</td>';
		
		$markup.='<td><input type="checkbox" name="presence[]" value="'.$row['id'].'"></input></td>';
		
		$q1 = 'SELECT ocena FROM oceny WHERE id_kursu = '.$courseId.' AND id_ucznia = ' .$row[1];

		
		$result1 = mysql_query($q1);
		
		$markup.='<td><table id="innerTable"><tr id="innerRow'.$row['id'].'">';
		
		while(($gradesRow = mysql_fetch_row($result1)) != ''){
			$markup.='<td>'.$gradesRow[0].'</td>';
		}
		$markup.='<td><input type="text" class="newGrade" name="'.$row['id'].'" /><input type="button" name="'.$row['id'].'" value="Dodaj ocene" onclick="addNewGrade(this)"/></td>';
		
		$markup.='</tr></table></td>';
		
		$markup.='</tr>';
	}
	$markup.='</tbody></table>';

	return $markup;
	
}

?>