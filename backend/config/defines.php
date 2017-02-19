<?php

//if (!defined('DB_HOST'))
//    DEFINE('DB_HOST', 'localhost');   //host 192.168.88.222
//if (!defined('DB_USER'))
//    DEFINE('DB_USER', '');    //username
//if (!defined('DB_PASSWORD'))
//    DEFINE('DB_PASSWORD', '');    //password
//if (!defined('DB_NAME'))
//    DEFINE('DB_NAME', '');  //database name
//if (!defined('DB_SQL_DEBUG_MODE'))
//    DEFINE('DB_SQL_DEBUG_MODE', false);

/* * **** */

/* Set Default Language */

if (!defined('DEFAULT_LANGUAGE'))
    DEFINE('DEFAULT_LANGUAGE', "hy");
if (!defined('MODULES'))
    DEFINE('MODULES', serialize(array(
        'site',
        'admin',
    )));
if (!defined('DEFAULT_MODULE'))
    DEFINE('DEFAULT_MODULE', "site");







//DEFINE('HTTP_TYPE', $_SERVER['HTTP_X_FORWARDED_PROTO']);
DEFINE('HTTP_ROOT', preg_replace('/^www\./', '', $_SERVER['HTTP_HOST']));

