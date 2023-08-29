<?php
if (strpos($argv[1], '--database') === false) {
    exit("Argument '--database' is required \n");
}

$database = str_replace('--database=', '', $argv[1]);
$filename = __DIR__ . "/migrates/{$database}.sql";
if (!file_exists($filename)) {
    exit("File '{$filename}' is not exists.\n");
}

error_reporting(E_ERROR);
define('PHP_ACTIVERECORD_AUTOLOAD_DISABLE', true);

require_once __DIR__ . '/vendor/autoload.php';

$username = 'root';
$password = 1;
$host = '127.0.0.1';
$dropTables = true;

new \Dcblogdev\SqlImport\Import(
    $filename, 
    $username, 
    $password, 
    $database, 
    $host, 
    $dropTables
);
