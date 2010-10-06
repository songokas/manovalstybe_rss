<?php

error_reporting(E_ALL ^ E_NOTICE);
mb_internal_encoding("UTF-8");

define('HOST', 'http://www.manovalstybe.lt/');
//define('HOST', '/');
define('IMAGE_PATH', APP_PATH."cache/");
define('IMAGE_URL', HOST."__scripts/cache/");

define('LIBRARY', APP_PATH.'libs/');
define('EXT', '.php');



function __autoload($class) {
    $class = strtolower($class);
    $path = LIBRARY.$class.EXT;
//    var_dump($path);
    if ( file_exists($path))
	require_once $path;
    else {
	throw new Exception('file does not exists:'.$path);
    }
}