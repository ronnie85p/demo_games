<?php namespace App\Model;

require_once __DIR__ . '/game.php';

class Genre extends Game
{
    public static $table_name = 'genres';

    static $has_one = [
        ['game']
    ];
}