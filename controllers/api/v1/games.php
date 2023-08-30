<?php namespace App\Controllers\Api\V1;

use App\Models\Game;

// api/v1/games/14

class GamesController extends \App\ApiController
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

    /**
     * @param array $data
     * @param array $params
     * @return array
     */
    public function prepareBeforeSave(array $data, int $id = 0): array
    {
        $this->getValidator();

        $errors = $this->validator->validation($data, $this->rules());
        if (empty($errors)) {
            Game::prepareBeforeSave($data);

            if (Game::doesExists($data, ['id' => $id])) {
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
        $genreId = (string) $this->inputHandler->get('genre_id', '');

        $conditions = '';
        if (!empty($genreId)) {
            $conditions = "genre_id = {$genreId}";
        }

        return [
            'conditions' => $conditions
        ];
    }

    public function toArray($model)
    {
        return array_merge($model->attributes(), [
            'genre' => $model->genre->attributes()
        ]);
    }

    public function create()
    {
        $post = $this->inputHandler->getOriginalPost();
        $errors = $this->prepareBeforeSave($post);

        if (empty($errors)) {
            if ($model = Game::create($post)) {
                $this->setResponseState('data', $this->toArray($model));
            } else {
                $this->setResponseState([
                    'status' => 500,
                    'message' => 'Error while object saving.'
                ]);
            }
        }

        return $this->getResponseStateJson([
            'errors' => $errors
        ]);
    }

    public function update(int $id)
    {
        if (!empty($model = Game::find(['id' => $id]))) {
            $post = $this->inputHandler->getOriginalPost();
            $errors = $this->prepareBeforeSave($post);
    
            $model->set_attributes($post);
            if (empty($errors) && !$model->save()) {
                $this->setResponseState([
                    'status' => 500,
                    'message' => 'Error while object saving.'
                ]);
            }

            $this->setResponseState([
                'errors' => $errors,
                'data' => $this->toArray($model)
            ]); 
        } else {
            $this->setResponseState([
                'status', 404, 
                'message' => 'Not found'
            ]);
        }

        return $this->getResponseStateJson();
    }

    public function get(int $id)
    {
        if (!empty($model = Game::find(['id' => $id]))) {
            $this->setResponseState('data', $this->toArray($model));
        } else {
            $this->setResponseState([
                'status', 404, 
                'message' => 'Not found'
            ]);
        }

        return $this->getResponseStateJson();
    }

    public function list()
    {
        $items = array_map(function ($model) { 
            return $this->toArray($model); 
        }, Game::find('all', $this->prepareListParams()));
 
        return $this->getResponseStateJson([
            'data' => $items
        ]);
    }

    public function delete(int $id)
    {
        if ($model = Game::find(['id' => $id])) {
            $model->delete();
        } else {
            $this->setResponseState([
                'status', 500, 
                'message' => 'Error while object deleting.'
            ]);
        }

        return $this->getResponseStateJson();
    }
}