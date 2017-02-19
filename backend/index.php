<?php
ini_set('display_errors', '1');
require_once "config/autoload.php";
require_once "config/defines.php";
/**/
$router = new \library\Application();
session_start();
$member = $router->Run();
session_write_close();

//$controller = $router->getControllerName();
//$action = $router->getAction();

