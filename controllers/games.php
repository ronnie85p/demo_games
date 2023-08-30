<?php namespace App\Controllers;

use App\Controllers\Api\V1\GamesController as ApiGamesController;
use App\Models\Game;
use App\Models\Genre;

class GamesController extends \App\Controller
{
    public $api;

    function __construct()
    {
        parent::__construct();

        $this->api = new ApiGamesController();
        $this->api->request = $this->request;
        $this->api->response = $this->response;
    }

    public function checkStatus($response)
    {
        if ($response['status'] !== 200) {
            throw new \Exception($response['message'], $response['status']);
        }
    }

    public function fromJSON($json)
    {
        return json_decode($json, true);
    }

    /**
     * @return string
     */
    public function getList()
    {
        $response = $this->fromJSON($this->api->list());
        $this->checkStatus($response);

        $genres = Genre::find('all');

        return $this->render('games/list', [
            'items' => $response['data'],
            'genres' => $genres
        ]);   
    }

    /**
     * @param int $id
     * @return string
     */
    public function get(int $id)
    {
        $response = $this->fromJSON($this->api->get($id));
        $this->checkStatus($response);

        return $this->render('games/item', $response);  
    }

    /**
     * @return string
     */
    public function create()
    {
        $response = [];
        
        if ($this->request->getMethod() === 'post') {
            $response = $this->fromJSON($this->api->create());
            $this->checkStatus($response);

            if (empty($response['errors'])) {
                $this->response->redirect("/games/{$response['data']['id']}");
            }
        }

        $genres = Genre::find('all');
        $response['genres'] = $genres;

        return $this->render('games/create', $response);  
    }

    /**
     * @param int $id
     * @return string
     */
    public function edit(int $id)
    {
        if ($this->request->getMethod() === 'post') {
            $response = $this->fromJSON($this->api->update($id));
            $this->checkStatus($response);

            $this->response->redirect("/games/{$id}");
        } else {
            $response = $this->fromJSON($this->api->get($id));
            $this->checkStatus($response);
        }

        $genres = Genre::find('all');
        $response['genres'] = $genres;
        return $this->render('games/edit', $response);  
    }

    /**
     * @param int $id
     */
    public function delete(int $id)
    {
        $response = $this->fromJSON($this->api->delete($id));
        $this->checkStatus($response);

        $this->response->redirect('/games');
    }
}