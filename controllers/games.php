<?php namespace App\Controllers;

use Pecee\Http\Input\InputHandler;
use Pecee\Http\Input\InputHandler\input;
use Pecee\Http\Request;
use Pecee\Http\Response;
use App\Models\Game;
use App\Models\Genre;

class GamesController extends \App\Controller
{
    public function rules()
    {
        return [
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
    }

    // /**
    //  * @param array $data
    //  * @param array $params
    //  * @return array
    //  */
    // public function prepareBeforeSave(array $data, array $params): array
    // {
    //     $this->getValidator();

    //     $errors = $this->validator->validation($data, $this->rules);
    //     if (empty($errors)) {
    //         Game::prepareBeforeSave($data);

    //         if (Game::doesExists($data, $params)) {
    //             $errors['name'] = \App\Core::$lang['games_such_game_already_exists'];
    //         }
    //     }

    //     return $errors;
    // }

    /**
     * @return array
     */
    public function prepareListParams()
    {
        $genreId = (string) $this->inputHandler->get('genre_id', '');

        $conditions = '';
        if (!empty($genreId)) {
            $conditions = "genre_id = {$genreId}";
        }

        return [
            'conditions' => $conditions
        ];
    }

    // /**
    //  * @return array
    //  */
    // public function getPostData()
    // {
    //     return filter_input_array(INPUT_POST, [
    //         'name'        => FILTER_SANITIZE_ENCODED,
    //         'description' => FILTER_SANITIZE_ENCODED,
    //         'author'      => FILTER_SANITIZE_ENCODED,
    //         'genre_id'    => FILTER_VALIDATE_INT,
    //     ]);
    // }

    /**
     * @param \Pecee\Http\Request $request
     * @return string
     */
    public function getList()
    {
        $items = Game::find('all', $this->prepareListParams());
        $genres = Genre::find('all');

        return $this->render('games/list', [
            'items' => $items,
            'genres' => $genres
        ]);   
    }

    /**
     * @param int $id
     * @return string
     */
    public function getItem(int $id)
    {
        $game = Game::find(['id' => $id]);
        if (empty($game)) {
            return $this->render('games/notfound');
        }

        return $this->render('games/item',  [
            'data' => $game
        ]);  
    }

    /**
     * @param int $id
     * @return string
     */
    public function create()
    {
        $errors = [];

        // if (!empty($_POST)) {
        //     $data = $this->getPostData();
        //     $errors = $this->prepareBeforeSave($data, $params);
        //     if (empty($errors)) {
        //         if ($game = Game::create($data)) {
        //             $this->redirect("/games/{$game->id}");
        //         } 
        //     }
        // }

        $genres = Genre::find('all');

        return $this->render('games/create', [
            // 'data' => $data,
            'genres' => $genres,
            'errors' => $errors
        ]);  
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return string
     */
    public function edit(Request $request, int $id)
    {
        return 'games/edit';
        $game = Game::find(['id' => $id]);
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
     * @param \Illuminate\Http\Request $request
     * @param int $id
     */
    public function delete(Request $request, int $id)
    {
        if ($game = Game::find(['id' => $id])) {
            $game->delete();
        }

        $this->redirect('/games/list');
    }


}

return __NAMESPACE__;