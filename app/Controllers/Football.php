<?php

namespace Controllers;

use Models\Database;

class Football
{
    private $footballTable;
    private $playerTable;
    private $authentication;

    /**
     * __construct
     *
     * @param  mixed $footballTable
     * @param  mixed $playerTable
     * @param  mixed $authentication
     * @return void
     */
    public function __construct(Database $footballTable, Database $playerTable, Authenticator $authentication)
    {
        $this->footballTable = $footballTable;
        $this->authentication = $authentication;
        $this->playerTable = $playerTable;
    }
    /**
     * homePage
     *
     * @return array
     */
    public function homePage(): array
    {
        $matches = $this->footballTable->displayData('date_posted', 6);
        $totalGames = $this->footballTable->total();
        $totalMembers = $this->authentication->getTotalUsers();
        $firstMatch = array_shift($matches);
        $title = 'Derrick Bets - eSports Prediction Platform';
        return ['template' => 'home.html.php', 'title' => $title, 'variables' => ['matches' => $matches, 'firstMatch' => $firstMatch, 'totalMembers' => $totalMembers, 'totalGames' => $totalGames]];
    }
    /**
     * aboutUs
     *
     * @return array
     */
    public function aboutUs(): array
    {
        $totalGames = $this->footballTable->total();
        $totalMembers = $this->authentication->getTotalUsers();
        $title = 'About Us  - Derrick Bets';
        return ['template' => 'about.html.php', 'title' => $title, 'variables' => ['totalMembers' => $totalMembers, 'totalGames' => $totalGames]];
    }

    public function displayResult()
    {
        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        $recordsPerPage = 10;
        $offset = ($page - 1) * $recordsPerPage; //calculate the number of pages to offset
        $games = $this->footballTable->displayData('date_posted DESC', $recordsPerPage, $offset);
        $totalGames = $this->footballTable->total();

        $title = 'Match Result | Derrick Bets';
        return [
            'template' => 'result.html.php', 'title' => $title,
            'variables' => [
                'games' => $games,
                'totalGames' => $totalGames,
                'recordsPerPage' => $recordsPerPage,
                'currentPage' => $page
            ]
        ];
    }

    /**
     * addGame
     *
     * @return array
     */
    public function addGame(): array
    {
        $user = $this->authentication->getUser();

        if (isset($_GET['game_id'])) {
            $game = $this->footballTable->findById($_GET['game_id']);
        }

        return [
            'template' => 'editgame.html.php',
            'title' => 'Create Game | Derrick Bets ',
            'variables' => ['game' => $game ?? null, 'user' => $user]
        ];
    }

    /**
     * joinMatch
     *
     * @return array
     */
    public function joinMatch(): array
    {
        if (isset($_GET['game_id'])) {
            $game = $this->footballTable->findById($_GET['game_id']);
        }
        $joinMatchJs = '<script src="/derrick/assets/js/joinmatch.js"></script>';
        return [
            'template' => 'joinmatch.html.php',
            'title' => 'Squares | Join Match',
            'variables' => ['game' => $game ?? null, 'joinMatchJs' => $joinMatchJs]
        ];
    }

    /**
     * processJoinMatch
     *
     * @return array
     */
    public function processJoinMatch(): array
    {
        $formData = $_POST;
        $valid = true;
        $errors = [];

        if (empty($formData['match_id'])) {
            $valid = false;
            $errors['match_id'] = 'match id cannot be blank';
        }
        if (empty($formData['match_password'])) {
            $valid = false;
            $errors['match_password'] = 'match password cannot be blank';
        }

        if (empty($formData['game_id'])) {
            $valid = false;
            $errors['game'] = 'Invalid request';
        }


        if ($valid) {
            //check if the football credentials is correct
            $football = $this->footballTable->find('game_id', $formData['game_id']);
            if (!empty($football) && ($football[0]->match_id == $formData['match_id']) && ($football[0]->match_password == $formData['match_password'])) {
                // get the current user
                $userObject = $this->authentication->getUser();
                //check if user is already registered to the game 
                $player = $this->playerTable->findByTwoColumns('game_id', $football[0]->game_id, 'user_id', $userObject->id);
                if (!empty($player) && intval($player[0]->can_play) == 1) {
                    $errors['game'] = 'Invalid request';
                    return [
                        'title' => 'Squares | Join Match',
                        'variables' => ['asynchronous' => $errors]
                    ];
                }
                //register the player with the game
                $playerData = [];
                $playerData['id'] = '';
                $playerData['game_id'] = $football[0]->game_id;
                $playerData['user_id'] = $userObject->id;
                $playerData['max_allowed'] = $football[0]->max_allowed;
                $playerData['firstname'] = $userObject->firstname;
                $playerData['lastname'] = $userObject->lastname;
                $playerData['email'] = $userObject->email;
                $playerData['can_play'] = 1;
                $this->playerTable->save($playerData);

                $message['message'] = "profile added to match successfully";

                return [
                    'title' => 'Squares | Join Match',
                    'variables' => ['asynchronous' => $message, 'message' => 'Success']
                ];
            }
            $errors['game'] = 'Invalid ID/Password';
            return [
                'title' => 'Squares | Join Match',
                'variables' => ['asynchronous' => $errors]
            ];
        } else {
            return [
                'title' => 'Squares | Join Match',
                'variables' => ['asynchronous' => $errors]
            ];
        }
    }

    public function removeMatch()
    {
        if (isset($_GET['game_id'])) {
            $game = $this->footballTable->findById($_GET['game_id']);
        }
        return [
            'template' => 'removematch.html.php',
            'title' => 'Derrick Bets | Remove Match',
            'variables' => ['game' => $game ?? null]
        ];
    }
    public function processRemoveMatch()
    {
        $formData = $_POST;
        //check if user can delete game
        //check if the football credentials is correct
        $userObject = $this->authentication->getUser();

        //check if user is already registered to the game 
        $player = $this->playerTable->findByTwoColumns('game_id', $formData['game_id'], 'user_id', $userObject->id);
        if (!empty($player) && intval($player[0]->can_play) == 1) {
            //delete squares
            $this->playerTable->deleteWhereTwoColumns('game_id', $formData['game_id'], 'user_id', $userObject->id);
        }

        header("location:/derrick/football/view");
        exit();
    }
    /**
     * deleteGame
     *
     * @return void
     */
    public function deleteGame()
    {
        $parameters = ['game_id' => $_POST['game_id']];
        $user = $this->authentication->getUser();
        //check if user can delete game
        if ($user->hasPermission(\Models\Entities\User::DELETE_GAME)) :
            $this->footballTable->removeData($parameters);
        endif;
        header("Location:/derrick/football/view");
        exit();
    }
    /**
     * footballList
     *
     * @return array
     */
    public function footballList(): array
    {
        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        $recordsPerPage = 10;
        $offset = ($page - 1) * $recordsPerPage; //calculate the number of pages to offset
        $user = $this->authentication->getUser();
        $games = $this->footballTable->displayData('date_posted DESC', $recordsPerPage, $offset);
        $players = $this->playerTable;
        $totalGames = $this->footballTable->total();

        return [
            'template' => 'gamelist.html.php', 'title' => "Squares | Football List",
            'variables' => [
                'games' => $games,
                'user' => $user,
                'players' => $players,
                'totalGames' => $totalGames,
                'recordsPerPage' => $recordsPerPage,
                'currentPage' => $page
            ]
        ];
    }

    /**
     * closeGame
     *
     * @return array
     */
    public function closeGame(): array
    {
        $formData = $_POST;
        $valid = true;
        $errors = [];
        // die("closeGame Recieved");
        if (empty($formData['title'])) {
            $valid = false;
            $errors['title'] = 'Please provide a valid match title';
        }
        if (empty($formData['max_allowed'])) {
            $valid = false;
            $errors['max_allowed'] = 'Please provide a valid max_allowed digit';
        }

        if (empty($formData['team_a'])) {
            $valid = false;
            $errors['team_a'] = 'Please provide a valid Team name';
        }

        if (empty($formData['team_b'])) {
            $valid = false;
            $errors['team_b'] = 'Please provide a valid Team name';
        }
        if (empty($formData['match_info'])) {
            $valid = false;
            $errors['match_info'] = 'Please provide a valid Information about the match';
        }
        //save the form data
        //$adminObject = $this->authentication->getUser();
        if ($valid) {
            $this->footballTable->update($formData);
            $message = [];
            $message['message'] = "Football successfully Created";
            // $message['note'] = "View the game";
            return [
                'title' => 'Football Successful',
                'variables' => ['asynchronous' => $message, 'message' => 'Success']
            ];
        } else {
            return [
                'title' => 'Football',
                'variables' => ['asynchronous' => $errors]
            ];
        }
    }

    /**
     * saveGame
     *
     * @return array
     */
    public function saveGame(): array
    {
        $formData = $_POST;
        $valid = true;
        $errors = [];
        $user = $this->authentication->getUser();
        if (!$user->hasPermission(\Models\Entities\User::EDIT_GAME)) :
            return null;
        endif;
        if (empty($formData['title'])) {
            $valid = false;
            $errors['title'] = 'Please provide a valid match title';
        }
        if (empty($formData['max_allowed'])) {
            $valid = false;
            $errors['max_allowed'] = 'Please provide a valid max_allowed digit';
        }

        if (empty($formData['team_a'])) {
            $valid = false;
            $errors['team_a'] = 'Please provide a valid Team name';
        }

        if (empty($formData['team_b'])) {
            $valid = false;
            $errors['team_b'] = 'Please provide a valid Team name';
        }

        if (empty($formData['match_date'])) {
            $valid = false;
            $errors['match_date'] = 'Please provide a valid match date';
        }
        if (empty($formData['match_time'])) {
            $valid = false;
            $errors['match_time'] = 'Please provide a valid match time';
        }
        if (empty($formData['match_info'])) {
            $valid = false;
            $errors['match_info'] = 'Please provide a valid Information about the match';
        }

        if ($valid) {

            $footballEntity = $this->footballTable->save($formData);
            $playerData = [];
            $playerData['game_id'] = $footballEntity->game_id;
            $playerData['user_id'] = $user->id;
            $playerData['id'] = '';
            $this->playerTable->save($playerData);

            $message = [];
            $message['message'] = "Football successfully Saved";
            // $message['note'] = "View the game";

            return [
                'title' => 'Football Successful',
                'variables' => ['asynchronous' => $message, 'message' => 'Success']
            ];
        } else {
            //if the data is not valid, show the form again
            return [
                'title' => 'Football',
                'variables' => ['asynchronous' => $errors]
            ];
        }
    }
}
