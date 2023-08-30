<?php namespace App;

use Jenssegers\Blade\Blade;
use Pecee\Http\Response;
use Pecee\SimpleRouter\SimpleRouter as Router;

abstract class Controller 
{
    public $compiler;
    public $validator;
    public $layout = 'layouts/default';

    /**
     * @var \Pecee\Http\Response
     */
    protected $response;

    /**
     * @var \Pecee\Http\Request
     */
    protected $request;

    /**
     * @var \Pecee\Http\Input\InputHandler
     */
    protected $inputHandler;

    public function __construct()
    {
        $this->request = Router::router()->getRequest();
        $this->response =  new Response($this->request);
        $this->inputHandler = $this->request->getInputHandler();
    }

    public function rules() { return []; }

    /**
     * @return \Jenssegers\Blade\Blade
     */
    public function getCompiler()
    {
        if (!$this->compiler) {
            $blade = new Blade(
                Core::$config['env']['views_path'], 
                Core::$config['env']['cache_path'] . 'blade'
            ); 

            $this->compiler = $blade;
        }

        return $this->compiler;
    }

    /**
     * @return \App\Validator
     */
    public function getValidator()
    {
        if (!$this->validator) {
            $this->validator = new Validator();
        }

        return $this->validator;
    }

    /**
     * @param string $tpl
     * @param array<> $data
     * @return string
     */
    public function renderTemplate(string $tpl, array $data = [])
    {
        return $this->compiler->render($tpl, $data);
    }

    /**
     * @param string $tpl
     * @param array $data
     * @return string
     */
    public function render(string $tpl, array $data = []) 
    {
        $this->getCompiler();

        $data = array_merge($data, [
            'config' => Core::$config['env'],
            'lang' => Core::$config['lang'],
        ]);

        $content = $this->renderTemplate($tpl, $data);

        if ($this->layout) {
            $content = $this->renderTemplate($this->layout, array_merge($data, [
                'content' => $content,
            ]));
        }

        return $content;
    }
}