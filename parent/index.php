<?php

include '../inc/Template.php';
include 'ChildrenCombobox.php';

session_start();

$tl = new Template('../tls/parent/index.html');

$combo = getChildrenCombobox($_SESSION['parentId']);

$tl->add("childrenCombobox", $combo);

echo $tl->execute();

?>