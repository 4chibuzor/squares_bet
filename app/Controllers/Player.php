<?php

namespace Controllers;

use Models\Database;

class Player
{
    private $playerTable;
    private $footballTable;
    private $authentication;

    /**
     * __construct
     *
     * @param  mixed $playerTable
     * @param  mixed $footballTable
     * @param  mixed $authentication
     * @return void
     */
    public function __construct(Database $playerTable, Database $footballTable, Authenticator $authentication)
    {
        $this->playerTable = $playerTable;
        $this->footballTable = $footballTable;
        $this->authentication = $authentication;
    }
    /**
     * getPlayersData
     *
     * @param  mixed $game_id
     * @return array
     */
    private function getPlayersData($game_id): array
    {
        $data = $this->playerTable->find('game_id', $game_id);
        return $data;
    }
    /**
     * getUpdatedGameData
     *
     * @param  mixed $game_id
     * @return array
     */
    private function getUpdatedGameData($game_id): array
    {
        $userObject = $this->authentication->getUser();
        $player = $this->playerTable->findByTwoColumns('game_id', $game_id, 'user_id', $userObject->id);
        //check if user can play the game
        if (empty($player) || intval($player[0]->can_play) != 1) {
            header("location:/derrick/football/join?game_id=" . $game_id);
            exit();
        }

        $results = $this->getPlayersData($game_id);
        $game = $this->footballTable->findById($game_id);
        $names_arr = array();
        $squares_arr = array();

        // check if game is valid
        if ($results) {
            foreach ($results as $result) {
                //check if there is a valid firstname
                if (!empty($result->squares)) :
                    $temp_name = "$result->firstname " . "$result->lastname";
                    $temp_squares = explode(',', "$result->squares");

                    array_push($names_arr, $temp_name);
                    array_push($squares_arr, $temp_squares);
                endif;
            }
        }

        $message = [];
        $message['message'] = " player game data recieved successfull";
        return  [
            'squares_arr' => $squares_arr,
            'names_arr' => $names_arr,
            'game_id' => $game_id,
            'game' => $game
        ];
    }

    /**
     * showGameBoard
     *  data for the football game square board on initialization
     * @return array
     */
    public function showGameBoard(): array
    {
        $game_id = $_GET['game_id'] ?? null;
        $variables = $this->getUpdatedGameData($game_id);
        $game = $variables['game'];
        $squaresCompleted = "<script>\n 
        var squaresCompleted = {
            game_id: '" . $game->game_id . "',
            title: '" . $game->title . "',
            max_allowed:'" . $game->max_allowed . "',
            team_a: '" . $game->team_a . "',
            team_b: '" . $game->team_b . "',
            match_info: '" . $game->match_info . "',
            completed:'no',
            horizontal: null,
            vertical: null,
        };\n </script>\n ";
        $gameClosedCompleted =  "<script>\n 
        var gameClosedHorizontal = [$game->horizontal];
        var gameClosedVertical = [$game->vertical];
        \n </script>\n ";
        $getPlayerData = "<script>\n  var taken_squares = " . json_encode($variables['squares_arr'])
            . "\n            var player_names = " . json_encode($variables['names_arr'])
            //. "\n            var winning_squares = " . json_encode($winners_arr)
            //. "\n            var winner_info = " . json_encode($winner_info_arr)
            . "\n        </script>\n";
        $variables['getPlayerData'] = $getPlayerData;
        $variables['squaresCompleted'] = $squaresCompleted;
        $variables['gameClosedCompleted'] =  $gameClosedCompleted;

        return ['template' => 'game.html.php', 'title' => 'Squares | Football Game', 'variables' => $variables];
    }

    private function checkForDuplicates($game_id, $squares_arr)
    {
        $master = array();
        $results = $this->getPlayersData($game_id);

        // check if game is valid i.e admin has  created the game
        if ($results) {
            $getResult = [];
            foreach ($results as $notEmpty) {
                if (!empty($notEmpty->squares)) :
                    $getResult[] = $notEmpty;
                endif;
            }

            $results = $getResult;
            foreach ($results as $result) {
                $temp = explode(',', $result->squares);
                foreach ($temp as $value) {
                    array_push($master, $value);
                }
            }

            foreach ($squares_arr as $value) {
                array_push($master, $value);
            }

            $temp_arr = array_count_values($master);
            $duplicates = array();

            foreach ($temp_arr as $key => $value) {
                if ($value > 1) {
                    array_push($duplicates, $key);
                }
            }
            sort($duplicates, SORT_REGULAR);

            return $duplicates;
        } else {
            echo "Game does not exist, contact admin";
            exit();
        }
    }

    public function footballGameProcessAjax()
    {
        $userObject = $this->authentication->getUser();
        $user_id = $userObject->id;
        $firstname = $userObject->firstname;
        $lastname = $userObject->lastname;
        $email = $userObject->email;
        $message = [];
        $message["output"] = '';

        if (!$user_id) {
            $output = " Player is not logged in ";
            $message["output"] = $output;
            print_r(json_encode($message));
            exit();
        }

        $game_id = strip_tags($_POST['game_id']);
        $squares = str_replace(' ', '', $_POST['squares']);
        $squares_arr = array_filter(explode(',', $squares));

        $results = $this->footballTable->find('game_id', $game_id);
        $user_prevs = $this->playerTable->findByTwoColumns('game_id', $game_id, 'user_id', $user_id);

        $user_old_scores = 0;
        foreach ($user_prevs as $user_prev) {
            $old_squares = array_filter(explode(',', $user_prev->squares));

            if (is_array($old_squares) && !empty($old_squares)) {
                $old_length = count($old_squares);
                $user_old_scores += $old_length;
            }
        }

        $max_squares = (int) $results[0]->max_allowed;
        $valid = true;
        $message["output"] = "";
        $message["output"] .= "Hi " . $firstname . " " . $lastname . " (" . $email . ")!\n";
        $message["output"] .= "<br><br>\n";

        // Check to make sure there are no empty fields.
        if ($firstname == "" || $lastname == "" || $email == "" || $squares == "") {
            $valid = false;
        }

        // Check to make sure user didn't select more than maximum number of squares.
        $user_total_squares = count($squares_arr) + $user_old_scores;

        if ($user_total_squares > $max_squares) {
            $message["output"] = "";
            $message["output"] .= "<font color = 'red'>You've selected too many squares! Only {$max_squares} squares per player is allowed.\n";
            $message["output"] .= "</b></font><br><br>\n";
            $valid = false;
        }

        // Check to make sure that there are no duplicates.
        // Duplicates happen if two users are choosing squares at the same time, so duplicate checking
        // should be done on server side.
        $duplicates = $this->checkForDuplicates($game_id, $squares_arr);
        if (count($duplicates)) {
            $message["output"] = "";
            $message["output"] .= "<font color='red'>Duplicate square(s) found! You have selected a square that has already been taken.\n";
            $message["output"] .= "</font><br><br>\n";
            $valid = false;
        }

        // Something went wrong .
        if ($valid == false) {
            $message["output"] .= "Please go back and edit your selections.\n";
            $message["output"] .= "<br><br>\n";
        } else {
            // if game is still active
            if ($results[0]->status == "close") {
                $message["output"] = "";
                $message["output"] .= "<font color = 'red'>This game has ended!.\n";
                $message["output"] .= "</b></font><br><br>\n";
                $valid = false;
            } else {
                // Data is valid, save it.
                $message["output"] = "";
                $message["output"] .= " Entering your squares into the database... \n";
                $tableData = [
                    'id' => '',
                    'game_id' => $game_id,
                    'user_id' => $user_id,
                    'max_allowed' => $max_squares,
                    'firstname' => $firstname,
                    'lastname' => $lastname,
                    'email' => $email,
                    'squares' => $squares
                ];

                $playerEntity = $this->playerTable->save($tableData);
                $message["output"] .= "<font color='green'>success!</font>\n";
                $message["output"] .= "<br><br>\n";
                $message["output"] .= "<h2>Thanks for playing " . $playerEntity->firstname . " and good luck!</h2>\n";
                $message["output"] .= "<br>\n";
            }
        }

        $getUpdatedData  = $this->getUpdatedGameData($_POST['game_id']);
        $message['squares_arr'] = $getUpdatedData['squares_arr'];
        $message['names_arr'] = $getUpdatedData['names_arr'];
        $message["output"] .= "\n";
        print_r(json_encode($message));
        die();
    }
}
