<?php

require_once '../inc/conf.php';
include '../inc/table.php';
include '../inc/Template.php';
include 'ChildrenCombobox.php';

session_start();

$childId = $_GET['childId'];
$parentId = $_SESSION['parentId'];
$_SESSION['childId'] = $childId;

$combo = getChildrenCombobox($parentId, $childId);
$table = getNotes($childId);


$tl = new Template('../tls/parent/index.html');

$tl->add('childrenCombobox', $combo);
$tl->add('content', $table);

echo $tl->execute();



function getNotes($childId){
	initDB();
	$q = 'SELECT @rownum := @rownum + 1 AS \'L.p.\', T1.* FROM ( SELECT u.tytul AS \'Tytu³\', u.komentarz AS Komentarz, ';
	$q.= ' u.timestamp AS Data, CONCAT(n.nazwisko, \' \', n.imie) AS Nauczyciel ';
	$q.= ' FROM uwagi u JOIN nauczyciele n ON u.id_nauczyciela = n.id ';
	$q.= ' WHERE u.id_ucznia = ' . $childId;
	$q.= ' ORDER BY u.timestamp ) T1, (SELECT @rownum := 0) r ';
	
	$result = mysql_query($q) or die ('select');
	
	$table = table($result);
	
	return $table;
	
	
}

?>