<?php namespace App\Controller;

require_once dirname(__DIR__) . '/model/game.php';
require_once dirname(__DIR__) . '/model/genre.php';

use App\Model\Game;
use App\Model\Genre;

class GamesController extends \App\Controller
{
    public $rules = [
        'name' => [
            'required' => true
        ],
        'description' => [
            'required' => true
        ],
        'genre_id' => [
            'required' => true
        ],
        'author' => [
            'required' => true
        ],  
    ];

    /**
     * @param array $data
     * @param array $params
     * @return array
     */
    public function prepareBeforeSave(array $data, array $params): array
    {
        $this->getValidator();

        $errors = $this->validator->validation($data, $this->rules);
        if (empty($errors)) {
            Game::prepareBeforeSave($data);

            if (Game::doesExists($data, $params)) {
                $errors['name'] = \App\Core::$lang['games_such_game_already_exists'];
            }
        }

        return $errors;
    }

    /**
     * @return array
     */
    public function prepareListParams()
    {
        $conditions = '';
        if (!empty($_GET['genre_id'])) {
            $conditions = "genre_id = {$_GET['genre_id']}";
        }

        return [
            'conditions' => $conditions
        ];
    }

    /**
     * @return array
     */
    public function getPostData()
    {
        return filter_input_array(INPUT_POST, [
            'name'        => FILTER_SANITIZE_ENCODED,
            'description' => FILTER_SANITIZE_ENCODED,
            'author'      => FILTER_SANITIZE_ENCODED,
            'genre_id'    => FILTER_VALIDATE_INT,
        ]);
    }

    /**
     * @param array $params
     * @return string
     */
    public function list(array $params)
    {
        $items = Game::find('all', $this->prepareListParams());
        $genres = Genre::find('all');

        return $this->render('games/list', [
            'items' => $items,
            'genres' => $genres
        ]);   
    }

    /**
     * @param array $params
     * @return string
     */
    public function create(array $params)
    {
        $errors = [];

        if (!empty($_POST)) {
            $data = $this->getPostData();
            $errors = $this->prepareBeforeSave($data, $params);
            if (empty($errors)) {
                if ($game = Game::create($data)) {
                    $this->redirect("/games/{$game->id}");
                } 
            }
        }

        $genres = Genre::find('all');

        return $this->render('games/create', [
            'data' => $data,
            'genres' => $genres,
            'errors' => $errors
        ]);  
    }

    /**
     * @param array $params
     * @return string
     */
    public function edit(array $params)
    {
        $game = Game::find(['id' => $params['id']]);
        if (empty($game)) {
            return $this->render('games/notfound');
        }

        $errors = [];

        if (!empty($_POST)) {
            $data = $this->getPostData();
            $errors = $this->prepareBeforeSave($data, $params);
            if (empty($errors)) {
                $game->set_attributes($data); 
                if ($game->save()) {
                    $this->redirect("/games/{$game->id}");
                } 
            }
        } else {
            $data = $game->attributes();
        }

        $genres = Genre::find('all');

        return $this->render('games/edit', [
            'data' => $data,
            'genres' => $genres,
            'errors' => $errors
        ]);  
    }

    /**
     * @param array $params
     */
    public function delete(array $params)
    {
        if ($game = Game::find(['id' => $params['id']])) {
            $game->delete();
        }

        $this->redirect('/games/list');
    }

    /**
     * @param array $params
     * @return string
     */
    public function item(array $params)
    {
        $game = Game::find(['id' => $params['id']]);
        if (empty($game)) {
            return $this->render('games/notfound');
        }

        return $this->render('games/item',  [
            'data' => $game
        ]);  
    }
}

return __NAMESPACE__;