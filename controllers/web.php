<?php namespace App\Controller;

class WebController extends \App\Controller 
{
    public function index()
    {
        return $this->render('web/index');
    }
}

return __NAMESPACE__;