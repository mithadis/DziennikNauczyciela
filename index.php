<?php

$file = file("./tls/index.html");

echo $file;

$site = implode("\n", $file);
echo $site;


?>