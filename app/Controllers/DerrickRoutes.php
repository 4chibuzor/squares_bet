<?php

namespace Controllers;

use \Models\Database;

class DerrickRoutes implements IRoutes
{
    private $userTable;
    private $footballTable;
    private $playerTable;
    public $authenticator;

    /**
     * __construct
     *
     * @return void
     */
    public function __construct()
    {
        $this->userTable = new Database('user', 'id', '\Models\Entities\User', [&$this->footballTable]);
        $this->footballTable = new Database('football', 'game_id', '\Models\Entities\Football', [&$this->userTable]);
        $this->passwordResetTable = new Database('pass_reset', 'token');
        $this->playerTable = new Database('player', 'id');
        $this->authenticator = new Authenticator($this->userTable, 'email', 'password');
    }
    /**
     * getRoutes
     *
     * @return array
     */
    public function getRoutes(): array
    {
        $registerController = new Register($this->userTable, $this->footballTable, $this->playerTable, $this->authenticator);
        $footballController = new Football($this->footballTable, $this->playerTable, $this->authenticator);
        $loginController = new Login($this->authenticator);
        $playerController = new Player($this->playerTable, $this->footballTable, $this->authenticator);
        $passwordResetController = new PasswordReset($this->passwordResetTable, $this->userTable);
        $routes = [
            '/derrick/' => [
                'GET' => [
                    'controller' => $footballController,
                    'action' => 'homePage'
                ]
            ],
            '/derrick/about' => [
                'GET' => [
                    'controller' => $footballController,
                    'action' => 'aboutUs'
                ],
            ],
            '/derrick/results' => [
                'GET' => [
                    'controller' => $footballController,
                    'action' => 'displayResult'
                ],
                'login' => true
            ],
            '/derrick/login' => [
                'GET' => [
                    'controller' => $loginController,
                    'action' => 'loginForm'
                ],
                'POST' => [
                    'controller' => $loginController,
                    'action' => 'processLogin'
                ]
            ],
            '/derrick/logout' => [
                'GET' => [
                    'controller' => $loginController,
                    'action' => 'logout'
                ]
            ],
            '/derrick/admin/permissions' => [
                'GET' => [
                    'controller' => $registerController,
                    'action' => 'permissions'
                ],
                'POST' => [
                    'controller' => $registerController,
                    'action' => 'savePermissions'
                ],
                'login' => true,
                'permissions' => \Models\Entities\User::EDIT_MEMBER_ROLES
            ],
            '/derrick/user/admin' => [
                'GET' => [
                    'controller' => $registerController,
                    'action' => 'adminDashobard'
                ],
                'login' => true
            ],
            '/derrick/activate' => [
                'GET' => [
                    'controller' => $registerController,
                    'action' => 'verifyAccount'
                ],

            ],
            '/derrick/404' => [
                'GET' => [
                    'controller' => $registerController,
                    'action' => 'pageNotFound'
                ],
            ],
            '/derrick/user/dashboard' => [
                'GET' => [
                    'controller' => $registerController,
                    'action' => 'dashBoard'
                ],
                'login' => true
            ],
            '/derrick/user/view' => [
                'GET' => [
                    'controller' => $registerController,
                    'action' => 'userList'
                ],
                'login' => true,
                'permissions' => \Models\Entities\User::DELETE_MEMBER
            ],
            '/derrick/user/delete' => [
                'POST' => [
                    'controller' => $registerController,
                    'action' => 'deleteUser'
                ],
                'login' => true,
                'permissions' => \Models\Entities\User::DELETE_MEMBER
            ],
            '/sendEmail' => [
                'POST' => [
                    'controller' => $registerController,
                    'action' => 'sendTestMail'
                ],
                'login' => true
            ],
            '/derrick/signup' => [
                'GET' => [
                    'controller' => $registerController,
                    'action' => 'addUser'
                ],
                'POST' => [
                    'controller' => $registerController,
                    'action' => 'registerUser'
                ]
            ],
            '/derrick/user/profile' => [
                'GET' => [
                    'controller' => $registerController,
                    'action' => 'editProfile'
                ],
                'POST' => [
                    'controller' => $registerController,
                    'action' => 'updateProfile'
                ],
                'login' => true
            ],
            '/derrick/football/create' => [
                'GET' => [
                    'controller' => $footballController,
                    'action' => 'addGame'
                ],
                'POST' => [
                    'controller' => $footballController,
                    'action' => 'saveGame'
                ],
                'login' => true,
                'permissions' => \Models\Entities\User::EDIT_GAME
            ],
            '/derrick/football/close' => [

                'POST' => [
                    'controller' => $footballController,
                    'action' => 'closeGame'
                ]
            ],
            '/derrick/football/view' => [
                'GET' => [
                    'controller' => $footballController,
                    'action' => 'footballList'
                ],
                'login' => true
            ],
            '/derrick/football/join' => [
                'GET' => [
                    'controller' => $footballController,
                    'action' => 'joinMatch'
                ],
                'POST' => [
                    'controller' => $footballController,
                    'action' => 'processJoinMatch'
                ],
                'login' => true
            ],
            '/derrick/football/remove' => [
                'GET' => [
                    'controller' => $footballController,
                    'action' => 'removeMatch'
                ],
                'POST' => [
                    'controller' => $footballController,
                    'action' => 'processRemoveMatch'
                ],
                'login' => true
            ],
            '/derrick/game/delete' => [
                'POST' => [
                    'controller' => $footballController,
                    'action' => 'deleteGame'
                ],
                'login' => true,
                'permissions' => \Models\Entities\User::DELETE_GAME
            ],
            '/derrick/game/view' => [
                'GET' => [
                    'controller' => $playerController,
                    'action' => 'showGameBoard'
                ],
                'POST' => [
                    'controller' => $playerController,
                    'action' => 'footballGameProcessAjax'
                ],
                'login' => true
            ],
            '/derrick/request/reset' => [
                'GET' => [
                    'controller' => $passwordResetController,
                    'action' => 'showForgotPassword'
                ],
                'POST' => [
                    'controller' => $passwordResetController,
                    'action' => 'handleForgotPassword'
                ]
            ],
            '/derrick/reset' => [
                'GET' => [
                    'controller' => $passwordResetController,
                    'action' => 'getMemberForgotByResetToken'
                ],
                'POST' => [
                    'controller' => $passwordResetController,
                    'action' => 'updateMemberPassword'
                ]
            ]

        ];
        return $routes;
    }

    /**
     * getAuthenticator
     *
     * @return Authenticator
     */
    public function getAuthenticator(): Authenticator
    {
        return $this->authenticator;
    }

    /**
     * checkPermission
     *
     * @param  mixed $permission
     * @return bool
     */
    public function checkPermission($permission): bool
    {
        $user = $this->authenticator->getUser();
        if ($user && $user->hasPermission($permission)) {
            return true;
        } else {
            return false;
        }
    }
}
