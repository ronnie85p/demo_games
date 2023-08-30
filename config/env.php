<?php

define('APP_BASE_PATH', dirname(__DIR__) . '/');
define('APP_CORE_PATH', APP_BASE_PATH . 'src/');
define('APP_CONFIG_PATH', APP_BASE_PATH . 'config/');
define('APP_CACHE_PATH', APP_BASE_PATH . 'cache/');
define('APP_MODELS_PATH', APP_BASE_PATH . 'models/');
define('APP_VIEWS_PATH', APP_BASE_PATH . 'views/');
define('APP_LANG_PATH', APP_BASE_PATH . 'lang/');
define('APP_CONTROLLERS_PATH', APP_BASE_PATH . 'controllers/');

return [
    'models_path' => APP_MODELS_PATH,
    'views_path' => APP_VIEWS_PATH,
    'cache_path' => APP_CACHE_PATH,  
    'lang_path' => 'lang',
    'locale' => 'ru',  
    'website' => 'Demo Games',
];