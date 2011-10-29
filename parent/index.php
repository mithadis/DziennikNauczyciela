<?php

include '../inc/Template.php';
include 'ChildrenCombobox.php';


$tl = new Template('../tls/parent/index.html');

$combo = getChildrenCombobox();

$tl->add("childrenCombobox", $combo);

echo $tl->execute();


?>