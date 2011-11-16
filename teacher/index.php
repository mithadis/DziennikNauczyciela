<?php

include '../inc/Template.php';
include 'ClassesCombobox.php';
include 'SubjectsList.php';

session_start();

$teacherId = $_SESSION['teacherId'];
$classId = $_GET['classId'];
$_SESSION['classId'] = $classId;

$classesCombo = getClassesCombobox($teacherId);
$subjectsList = getSubjectsList();

$tl = new Template('../tls/teacher/index.html');
$tl->add('classCombobox', $classesCombo);
$tl->add('subjectsList', $subjectsList);

echo $tl->execute();


?>