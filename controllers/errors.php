<?php namespace App\Controllers;

class ErrorsController extends \App\Controller 
{
    public function notFound()
    {
        return $this->render('errors/404');
    }

    public function accessDenied()
    {
        return $this->render('errors/403');
    }
}