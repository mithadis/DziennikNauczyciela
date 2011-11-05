<?php

define('ROOTPATH', 'DziennikNauczyciela/');

include 'inc/Template.php';



$tl = new Template('tls/index.html');

echo $tl->execute();

?>