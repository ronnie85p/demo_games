<?php namespace App;

class Router
{
    static public function route(string $route, $controller)
    {
        $uri = trim($_REQUEST['q'], '/');
        $route = trim($route, '/');
        $params = [];

        $routes = explode('/', $route);
        foreach ($routes as $i => $r) {
            if (strpos($r, ':') !== false) {
                $params[$i] = str_replace(':', '', $r);
            }
        }
        
        $uri = explode('/', $uri);
        foreach ($params as $i => $p) {
            $params[$p] = $uri[$i];
            $uri[$i] = ':' . $p;
            unset($params[$i]);
        }

        $uri = implode('/', $uri);
        if ($uri !== $route) {
            return;
        }

        $controller = is_callable($controller) ? $controller($route, $params) : $controller;
        $paths = explode('/', $controller);
        $action = array_pop($paths);

        $controllerFile = dirname(__DIR__) . '/controllers/' . strtolower(implode('/', $paths)) . '.php';
        if (!file_exists($controllerFile)) {
            throw new \ErrorException("Router: Controller '{$controllerFile}' is not exists");
        }

        $NS = require $controllerFile;
        $controllerClass = $NS . '\\' . implode('\\', $paths) . 'Controller';
        if (!class_exists($controllerClass)) {
            throw new \ErrorException("Router: Class '{$controllerClass}' is not exists");
        }
       
        $controller = new $controllerClass();
        if (!method_exists($controller, $action)) {
            throw new \ErrorException("Router: Action '{$action}' of '{$controllerClass}' is not exists");
        }

        echo $controller->$action($params);
    }
}