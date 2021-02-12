<?php

namespace Models\Entities;

use Models\Database;

class Football
{
    public $game_id;
    public $admin_id;
    public $title;
    public $max_allowed;
    public $match_id;
    public $match_password;
    public $team_a;
    public $team_b;
    public $match_info;
    public $status;
    public $completed;
    public $date_posted;
    private $admin;
    private $usersTable;

    /**
     * __construct
     *
     * @param  mixed $usersTable
     * @return void
     */
    public function __construct(Database $usersTable)
    {
        $this->usersTable = $usersTable;
    }

    public function getAdmin()
    {
        if (empty($this->admin)) {
            $this->admin = $this->usersTable->findById($this->admin_id);
        }
        return $this->admin;
    }
}
