<?php

namespace Models\Entities;

class Player
{
    public $id;
    public $game_id;
    public $user_id;
    public $max_allowed;
    public $firstname;
    public $lastname;
    public $email;
    public $squares;

    public function __construct()
    {
    }
}
