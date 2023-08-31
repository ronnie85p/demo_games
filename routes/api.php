<?php
use App\Controllers\Api\V1\GamesController;
use Pecee\SimpleRouter\SimpleRouter as Router;

Router::get('/api/v1/games', [GamesController::class, 'list']);
Router::post('/api/v1/games', [GamesController::class, 'create']);
Router::get('/api/v1/games/{id}', [GamesController::class, 'get'])->where(['id' => '[0-9]+']);
Router::put('/api/v1/games/{id}', [GamesController::class, 'update'])->where(['id' => '[0-9]+']);
Router::delete('/api/v1/games/{id}', [GamesController::class, 'delete'])->where(['id' => '[0-9]+']);

// fixed