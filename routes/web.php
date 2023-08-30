<?php
use Pecee\SimpleRouter\SimpleRouter as Router;
use Pecee\Http\Request;
use Pecee\Http\Response;

Router::get('/', 'WebController@index');
Router::get('/errors/403', 'ErrorsController@accessDenied');
Router::get('/errors/404', 'ErrorsController@notFound');
Router::get('/games', 'GamesController@getList');
Router::get('/games/{id}', 'GamesController@getItem')->setMatch('[0-9]+');
Router::get('/games/create', 'GamesController@create');
Router::post('/games/create', 'GamesController@create');
Router::put('/games/{id}', 'GamesController@edit')->setMatch('[0-9]+');
Router::delete('/games/{id}', 'GamesController@delete')->setMatch('[0-9]+');

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