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
$table = getContact($childId);


$tl = new Template('../tls/parent/index.html');

$tl->add('childrenCombobox', $combo);
$tl->add('content', $table);

echo $tl->execute();


function getContact($childId){

	mysql_connect(DB_SERVER, DB_LOGIN, DB_PASS) or die('connect');
	mysql_query('USE dn') or die('use');

	$q = 'SELECT CONCAT(n.nazwisko, \' \', n.imie) AS Wychowawca, ku.przedmiot AS Przedmiot, email AS \'E-mail\',';
	$q.= ' telefon AS Telefon FROM uczniowie u JOIN klasy kl ON u.id_klasy = kl.id JOIN nauczyciele n ON ';
	$q.= ' kl.id_wychowawcy = n.id JOIN kursy ku ON kl.id_wychowawcy = ku.id_nauczyciela WHERE u.id = ' . $childId;
	
	$result = mysql_query($q) or die ('select');
	$table = table($result);
	
	$q = 'SELECT CONCAT(n.nazwisko, \' \', n.imie) AS Nauczyciel, ku.przedmiot AS Przedmiot, email AS \'E-mail\',';
	$q.= ' telefon AS Telefon FROM nauczyciele n JOIN kursy ku ON n.id = ku.id_nauczyciela ';
	$q.= ' JOIN klasy kl ON ku.id_klasy = kl.id JOIN uczniowie u ON u.id_klasy = kl.id WHERE u.id = ' . $childId;
	
	$result = mysql_query($q) or die ('select');
	$table .= table($result);

	return $table;
}
?>