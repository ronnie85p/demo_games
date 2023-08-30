<?php 
error_reporting(E_ERROR);
define('PHP_ACTIVERECORD_AUTOLOAD_DISABLE', true);

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/routes/api.php';
require_once __DIR__ . '/routes/web.php';

use Pecee\SimpleRouter\SimpleRouter as Router;

App\Core::run('config');

Router::setDefaultNamespace('\\App\\Controllers');
Router::start();
