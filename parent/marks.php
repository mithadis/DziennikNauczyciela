<?php

include '../inc/conf.php';
include '../inc/table.php';
include '../inc/Template.php';
include 'ChildrenCombobox.php';

session_start();

$childId = $_POST['childId'];
$parentId = $_SESSION['parentId'];
$_SESSION['childId'] = $childId;


$q = 'SELECT @rownum := @rownum + 1 AS \'L.p.\', k.przedmiot AS Przedmiot, ocena AS Ocena, timestamp AS Data, CONCAT(n.nazwisko, \' \', n.imie) as Nauczyciel FROM ';
$q.= ' oceny o JOIN kursy k ON o.id_kursu = k.id JOIN nauczyciele n ON k.id_nauczyciela = n.id , (SELECT @rownum := 0 ) r';
$q.= ' WHERE o.id_ucznia = ' . $childId . ' ORDER BY k.przedmiot';

mysql_connect(DB_SERVER, DB_LOGIN, DB_PASS);
mysql_query('USE dn') or die('use');

$result = mysql_query($q) or die('koniec select; marks.php');

$table = table($result, $thead);

$combo = getChildrenCombobox($parentId, $childId);

$tl = new Template('../tls/parent/index.html');

$tl->add('childrenCombobox', $combo);
$tl->add('content', $table);

echo $tl->execute();


?>