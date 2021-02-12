<?php

namespace Controllers;

class Login
{
    private $authentication;

    /**
     * __construct
     *
     * @param  mixed $authentication
     * @return void
     */
    public function __construct(Authenticator $authentication)
    {
        $this->authentication = $authentication;
    }

    /**
     * loginForm
     *
     * @return array
     */
    public function loginForm(): array
    {
        $title = 'Sign In - Derrick Bets ';
        $loggedIn = $this->authentication->isLoggedIn();
        $loginJs = '<script src="/derrick/assets/js/login.js"></script>';
        //check if user is already logged in
        if ($loggedIn) {
            header("location:/derrirck/user/dashboard");
            exit();
        }
        return ['template' => 'login.html.php', 'title' => $title, 'variables' => ['loginJs' => $loginJs]];
    }

    /**
     * processLogin
     *
     * @return array
     */
    public function processLogin(): array
    {
        if ($this->authentication->login($_POST['email'], $_POST['password'])) {
            return [
                'title' => 'Login Successful',
                'variables' => ['asynchronous' => ['message' => "Login was successfull"]]
            ];
        } else {
            return [
                'title' => 'Log In',
                'variables' => ['asynchronous' => ['error' => 'Invalid username or password']]
            ];
        }
    }

    /**
     * logout
     *
     * @return void
     */
    public function logout()
    {
        session_destroy();
        $_SESSION = [];
        unset($_SESSION);
        header("location:/derrick/");
    }
}
