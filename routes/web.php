<?php
use Pecee\SimpleRouter\SimpleRouter as Router;
use Pecee\Http\Request;
use Pecee\Http\Response;

// Web
Router::get('/', 'WebController@index');

// Errors
Router::get('/errors/403', 'ErrorsController@accessDenied');
Router::get('/errors/404', 'ErrorsController@notFound');

// Games
Router::get('/games', 'GamesController@getList');
Router::get('/games/create', 'GamesController@create');
Router::post('/games/create', 'GamesController@create');
Router::get('/games/{id}', 'GamesController@get')->where(['id' => '[0-9]+']);
Router::get('/games/edit/{id}', 'GamesController@edit')->where(['id' => '[0-9]+']);
Router::post('/games/edit/{id}', 'GamesController@edit')->where(['id' => '[0-9]+']);
Router::get('/games/delete/{id}', 'GamesController@delete')->where(['id' => '[0-9]+']);

// Error handler
Router::error(function (Request $request, \Exception $exception) {
    $response = new Response($request);
    
    switch($exception->getCode()) {
        case 403:
            $response->redirect('/errors/403');
        break;
        case 404:
            $response->redirect('/errors/404');
        break;
    }
});