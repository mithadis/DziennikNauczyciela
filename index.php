<?php

define('ROOTPATH', 'DziennikNauczyciela/');

include 'inc/Template.php';

//phpinfo();

$tl = new Template('tls/index.html');

echo $tl->execute();

?>