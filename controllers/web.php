<?php namespace App\Controllers;

class WebController extends \App\Controller 
{
    public function index()
    {
        return $this->render('web/index');
    }
}