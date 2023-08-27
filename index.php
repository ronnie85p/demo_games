<?php 

error_reporting(E_ERROR);
define('PHP_ACTIVERECORD_AUTOLOAD_DISABLE', true);

require_once __DIR__ . '/vendor/autoload.php';

App\Core::run([
    'env' => __DIR__ . '/config/env.php',
    'db' => __DIR__ . '/config/db.php',
    'lang' => __DIR__ . '/lang/ru/default.inc.php',
]);
