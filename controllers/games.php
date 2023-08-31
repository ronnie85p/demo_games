<?php namespace App\Controllers;

use App\Models\Genre;

class GamesController extends \App\Controller
{
    private $apiConnection = [];

    function __construct()
    {
        parent::__construct();

        $this->apiConnection = [
            'url' => 'http://localhost/api/v1/',
            'port' => 80,
            'proxy' => $_SERVER['SERVER_ADDR'] . ':80'
        ];
    }

    public function getApiResponse($method, $action, $data = [])
    {
        $method = strtoupper($method);
        $url = $this->apiConnection['url'] . $action;
        $ch = curl_init();

        if (!empty($data)) {
            switch ($method) {
                case 'GET':
                    $params = http_build_query($data);
                    $url .= "?{$params}";
                    break;

                case 'POST':
                    $payload = json_encode($data);
                    curl_setopt($ch, CURLOPT_POST, true);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
                    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type:application/json']);
                    break;
            }
        }

        curl_setopt_array($ch, [
            // Point Connection
            CURLOPT_PORT => $this->apiConnection['port'],
            CURLOPT_URL => $url,
            CURLOPT_CUSTOMREQUEST => $method,

            // Proxy for Docker
            CURLOPT_PROXY => $this->apiConnection['proxy'],
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER => false,

            // SSL
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false,
        ]);

        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            $error = curl_error($ch);
            throw new \Exception($error, 500);
        }

        $response = json_decode($response, true);

        if ($response['status'] !== 200) {
            throw new \Exception(
                $response['message'], 
                $response['status']
            );
        }

        return $response;
    }

    /**
     * @return string
     */
    public function getList()
    {
        $response = $this->getApiResponse('GET', 'games', 
            $this->inputHandler->getOriginalParams());
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
        $response = $this->getApiResponse('GET', "games/{$id}");

        return $this->render('games/item', $response);  
    }

    /**
     * @return string
     */
    public function create()
    {
        $response = [];

        if ($this->request->getMethod() === 'post') {
            $response = $this->getApiResponse('POST', "games", 
                $this->inputHandler->getOriginalPost()
            );

            if (empty($response['errors'])) {
                $this->response->redirect("/games/{$response['data']['id']}");
            }

            if (empty($response['data'])) {
                $response['data'] = $this->inputHandler->getOriginalPost();
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
            $response = $this->getApiResponse('POST', "games/{$id}", 
                $this->inputHandler->getOriginalPost()
            );

            if (empty($response['errors'])) {
                $this->response->redirect("/games/{$id}");
            }

            if (empty($response['data'])) {
                $response['data'] = $this->inputHandler->getOriginalPost();
            }
        } else {
            $response = $this->getApiResponse('GET', "games/{$id}");
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
        $response = $this->getApiResponse('DELETE', "games/{$id}");

        $this->response->redirect('/games');
    }
}