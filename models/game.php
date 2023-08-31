<?php namespace App\Models;

class Game extends \ActiveRecord\Model
{
    static $table_name = 'games';

    static $belongs_to = [
        ['genre']
    ];

    public function to_array($options = [])
    {
        $array = parent::to_array($options);
        foreach (array_column(self::$belongs_to, 0) as $t) {
            $array[$t] = $this->$t->attributes();
        }

        return $array;
    }

    public static function prepareBeforeSave(array &$data)
    {
        $data['name'] = ucfirst(trim($data['name']));
        $data['description'] = ucfirst(trim($data['description']));
        $data['author'] = ucfirst(trim($data['author']));
        $data['genre_id'] = (int) $data['genre_id'];
    }

    public static function doesExists(array $data, array $exclude = [])
    {
        $criteria = [
            'conditions' => [
                'name=? and genre_id =? and id !=?', 
                $data['name'], 
                $data['genre_id'], 
                empty($exclude['id']) ? 0 : $exclude['id']
            ]
        ];

        return parent::exists($criteria);
    }
}