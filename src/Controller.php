<?php namespace App;

use Jenssegers\Blade\Blade;

class Controller 
{
    public $validator;
    public $layout = 'layouts/default';

    public function getCompiler()
    {
        return new Blade(
            dirname(__DIR__) . '/views', 
            dirname(__DIR__) . '/cache/blade'
        ); 
    }

    public function getValidator()
    {
        if (!$this->validator) {
            $this->validator = new Validator();
        }

        return $this->validator;
    }

    public function redirect(string $uri, array $params = [])
    {
        $params = http_build_query($params);
        $params = empty($params) ? '' : '?' . $params;

        header("Location: {$uri}{$params}");
    }

    public function render(string $tpl, array $data = []) 
    {
        $compiler = $this->getCompiler();

        $data = array_merge($data, ['config' => \App\Core::$config]);
        $output = $compiler->render($tpl, $data);

        if ($this->layout) {
            $output = $compiler->render($this->layout, array_merge($data, [
                'content' => $output,
            ]));
        }

        return $output;
    }
}