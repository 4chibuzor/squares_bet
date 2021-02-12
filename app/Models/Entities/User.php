<?php

namespace Models\Entities;

use Models\Database;

class User
{
    const EDIT_GAME = 1;
    const DELETE_GAME = 8;
    const DELETE_MEMBER = 16;
    const EDIT_MEMBER_ROLES = 32;

    public $id;
    public $firstname;
    public $lastname;
    public $email;
    public $password;
    public $location;
    public $permission;
    public $activated;
    public $date_joined;
    public $footballTable;



    /**
     * __construct
     *
     * @param  mixed $footballTable
     * @return void
     */
    public function __construct(Database $footballTable)
    {
        $this->footballTable = $footballTable;
    }


    public function getFootballGames()
    {
        $games = $this->footballTable->find('game_id', $this->id);
        return $games;
    }

    public function getTotalGames()
    {
        $total = $this->footballTable->total();
        return $total;
    }

    public function getDashBoardGames($orderBy, $limit, $offset)
    {
        $games = $this->footballTable->displayData($orderBy, $limit, $offset);
        return $games;
    }

    public function addFootball($football)
    {
        $football['admin_id'] = $this->id;
        $football = $this->footballTable->save($football);
        return $football;
    }


    public function hasPermission($permission)
    {
        return $this->permission & $permission;
    }
}
