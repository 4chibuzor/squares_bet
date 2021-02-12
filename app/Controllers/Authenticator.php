<?php

namespace Controllers;

use Models\Database;

class Authenticator
{
    private $users;
    private $usernameColumn;
    private $passwordColumn;


    /**
     * __construct
     *
     * @param  mixed $users
     * @param  mixed $usernameColumn
     * @param  mixed $passwordColumn
     * @return void
     */
    public function __construct(Database $users, $usernameColumn, $passwordColumn)
    {
        session_start();
        $this->users = $users;
        $this->usernameColumn = $usernameColumn;
        $this->passwordColumn = $passwordColumn;
    }


    /**
     * login
     *
     * @param  mixed $username
     * @param  mixed $password
     * @return bool
     */
    public function login($username, $password): bool
    {
        $user = $this->users->find($this->usernameColumn, strtolower($username));

        if (!empty($user) && password_verify($password, $user[0]->{$this->passwordColumn})) {
            //session_regenerate_id();

            $_SESSION['username'] =  $username;
            $_SESSION['firstname'] =  $user[0]->firstname;
            // $_SESSION['user_id'] =  $user[0]->id;
            $_SESSION['password'] =  $user[0]->{$this->passwordColumn};
            return true;
        } else {
            return false;
        }
    }

    /**
     * isLoggedIn
     *
     * @return bool
     */
    public function isLoggedIn(): bool
    {
        if (empty($_SESSION['username'])) {
            return false;
        }

        $user = $this->users->find($this->usernameColumn, strtolower($_SESSION['username']));
        if (!empty($user) && $user[0]->{$this->passwordColumn} === $_SESSION['password']) {
            return true;
        } else {
            return false;
        }
    }

    public function getUser()
    {
        if ($this->isLoggedIn()) {
            return $this->users->find($this->usernameColumn, strtolower($_SESSION['username']))[0];
        } else {
            return false;
        }
    }
    public function getTotalUsers()
    {
        $totalMembers = $this->users->total();
        return $totalMembers;
    }
}
