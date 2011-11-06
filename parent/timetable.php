<?php

include '../inc/conf.php';
include '../inc/table.php';
include '../inc/Template.php';
include 'ChildrenCombobox.php';

session_start();

$childId = $_POST['childId'];
$parentId = $_SESSION['parentId'];
$_SESSION['childId'] = $childId;

$table = getTimetable($childId);
$combo = getChildrenCombobox($parentId, $childId);

$tl = new Template('../tls/parent/index.html');

$tl->add('childrenCombobox', $combo);
$tl->add('content', $table);


echo $tl->execute();


function getTimetable($childId){
	
	$q = 'SELECT CASE dzien_tyg WHEN 1 THEN \'Poniedzia³ek\' WHEN 2 THEN';
	$q.= ' \'Wtorek\' WHEN 3 THEN \'Œroda\' WHEN 4 THEN \'Czwartek\' WHEN 5 THEN \'Pi¹tek\' END AS \'Dzieñ tygodnia\',';
	$q.= ' miejsce AS Sala, od AS \'Od godziny\', do AS \'Do godziny\', ku.przedmiot AS \'Przedmiot\'';
	$q.= ' FROM uczniowie u JOIN klasy kl ON u.id_klasy = kl.id JOIN kursy ku ON kl.id = ku.id ';
	$q.= ' JOIN terminy t ON ku.id = t.id_kursu JOIN godziny g ON t.id_godziny = g.id WHERE u.id = ' . $childId;
	$q.=' ORDER BY dzien_tyg';
	
	mysql_connect(DB_SERVER, DB_LOGIN, DB_PASS);
	mysql_query('USE dn');
	
	$result = mysql_query($q);
	
	$table = table($result);
	
	return $table;
	
}

?>