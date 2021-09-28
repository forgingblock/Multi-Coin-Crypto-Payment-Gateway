<?php
error_reporting(-1);

$paths = array(
	'base' => __DIR__.'',
	'assets'  => __DIR__.'/../assets',
	'extra' => __DIR__.'/../extra'
);

if (function_exists('mb_internal_encoding')) {
	mb_internal_encoding('utf-8');
}

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}


require_once $paths['base'] .'/database/vendor/autoload.php';
require_once('config.php');
require_once('database.php');
require_once('Product.php');
require_once('helpers.php');
require 'lib/Forgingblock.php';


if (!empty(Config::get('app:timezone'))) {
	date_default_timezone_set(Config::get('app:timezone'));
}


if (version_compare(PHP_VERSION, '5.5.9', '>=')) {    
    if (!Config::get('app:debug')) ini_set('display_errors', 'Off');
}














