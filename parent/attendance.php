<?php

include '../inc/conf.php';
include '../inc/table.php';
include '../inc/Template.php';
include 'ChildrenCombobox.php';

session_start();

$childId = $_GET['childId'];
$parentId = $_SESSION['parentId'];
$_SESSION['childId'] = $childId;

$combo = getChildrenCombobox($parentId, $childId);



$table = '<form method="POST" action="/DziennikNauczyciela/parent/explainAbsence.php">';
$table .= getAttendanceTable($childId);

$table .= '<input type="submit" value="Usprawiedliwiaj"/>';
$table .= '</form>';


$tl = new Template('../tls/parent/index.html');

$tl->add('childrenCombobox', $combo);
$tl->add('content', $table);

echo $tl->execute();


function getAttendanceTable($childId){

	mysql_connect(DB_SERVER, DB_LOGIN, DB_PASS) or die('connect');
	mysql_query('USE dn') or die('use');

	$q = 'SELECT  @rownum := @rownum + 1 AS \'L.p.\', T1.* FROM (SELECT data AS Data, g.od As Od, g.do AS Do, status AS Status, ';
	$q.= ' CASE uspr WHEN 1 THEN \'TAK\' WHEN 0 THEN \'NIE\' END AS \'Czy usprawiedliowione?\', ';
	$q.= ' CASE uspr WHEN 0 THEN CONCAT(\'<input type="checkbox" name="explainAbsence" value="\',o.id,\'"/>\') END AS \'Czy usprawiedliwiæ?\'  ';
	$q.= ' FROM obecnosci o JOIN godziny g ON o.id_godziny = g.id';
	$q.= ' WHERE id_ucznia = ' . $childId . ' ORDER BY data ) T1, (SELECT @rownum := 0 ) r ';

	$result = mysql_query($q) or die ('select');

	
	$table .= table($result);

	return $table;
}

?>