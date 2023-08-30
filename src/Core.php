<?php namespace App;

class Core
{
    static $config = [];
    static $lang = [];
    static $default_connection = 'test';
    static $connection_datetime_format = 'Y-m-d H:i:s';
    static $connections = [];

    /**
     * @param string $config_path
     */
    public static function run(string $config_path)
    {
        self::loadConfig($config_path);
        self::$lang = self::$config['lang'];

        $model_path = self::$config['env']['models_path'] ?: dirname(__DIR__) . '/models';
        self::dbConnection(
            self::$config['db'], 
            $model_path
        );
    }

    /**
     * @param string $path
     */
    public static function loadConfig(string $path)
    {
        $path = dirname(__DIR__) . '/' . trim($path, '/') . '/';
        $files = array_diff(scandir($path) ?: [], ['..', '.']);
        
        self::$config = [];
        foreach ($files as $file) {
            $fullpath = $path . $file;
            if (!file_exists($fullpath) || !is_file($fullpath)) {
                continue;
            }

            $config = include($fullpath);
            self::$config[preg_replace('/\..+$/', '', $file)] = $config;
        }
    }

    /**
     * @param array $config
     * @param string $model_path
     */
    public static function dbConnection(array $config, string $model_path)
    {
        self::$connections[self::$default_connection] = "{$config['type']}://{$config['username']}:{$config['password']}@{$config['host']}/{$config['database']}?charset={$config['charset']}";
        
        $cfg = \ActiveRecord\Config::instance();
        $cfg->set_model_directory($model_path);
        $cfg->set_connections(self::$connections);
        $cfg->set_default_connection(self::$default_connection);

        \ActiveRecord\Connection::$datetime_format = self::$connection_datetime_format;
    }
}