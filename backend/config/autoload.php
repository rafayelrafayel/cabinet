<?php

//error_reporting(E_ALL ^ E_NOTICE);

/* autoload classses */

function __autoload($class_name)
{
    $path = str_replace("\\", "/", $class_name);
    include_once($path . ".php");
}