<?php namespace App;

class ApiController extends Controller
{
    /**
     * @var array
     */
    public $responseState = [
        'status' => 200,
        'message' => 'OK',
        'errors' => [],
        'data' => []
    ];

    /**
     * @param array|string $k
     * @param $v;
     */
    public function setResponseState(array|string $k, $v = '')
    {
        $values = $k;
        if (!is_array($values)) {
            $values = [$k => $v];
        }

        foreach ($values as $_k => $_v) {
            if (isset($this->responseState[$_k])) {
                $this->responseState[$_k] = $_v;
            }
        }
    }

    /**
     * @return array
     */
    public function getResponseState()
    {
        return $this->responseState;
    }

    /**
     * @param array $state
     * @return string
     */
    public function getResponseStateJson(array $state = [])
    {   
        $this->setResponseState($state);

        return json_encode($this->getResponseState());
        return $this->response->json(
            $this->getResponseState()
        );
    }
}