<?php


require '../autoload.php';
$routes = new \Jjobs\Routes();
$entryPoint = new \CSY2028\EntryPoint($routes);
$entryPoint->run();


