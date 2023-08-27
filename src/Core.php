<?php namespace App;

class Core
{
    static $config = [];
    static $lang = [];
    public static function run(array $config)
    {
        if (!file_exists($config['db'])) {
            throw new \Exception('Config file not exists');
        }

        $db = include($config['db']);
        $connections = ['test' => "{$db['type']}://{$db['username']}:{$db['password']}@{$db['host']}/{$db['database']}?charset={$db['charset']}"];

        $cfg = \ActiveRecord\Config::instance();
        $cfg->set_model_directory($env['model_path']);
        $cfg->set_connections($connections);
        $cfg->set_default_connection('test');

        \ActiveRecord\Connection::$datetime_format = 'Y-m-d H:i:s';

        $env = include($config['env']);
        self::$config = $env;

        $_lang = [];
        include($config['lang']);
        self::$lang = $_lang;

        foreach ($env['routes'] as $route => $controller) {
            Router::route($route, $controller);
        }
    }
}