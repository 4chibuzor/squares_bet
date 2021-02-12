<?php

namespace Controllers;


class DerrickRouter
{
    private $route;
    private $method;
    private $routes;

    /**
     * __construct
     *
     * @param  mixed $route
     * @param  mixed $method
     * @param  mixed $routes
     * @return void
     */
    public function __construct(string $route, string $method, IRoutes $routes)
    {
        $this->route = $route;
        $this->method = $method;
        $this->routes = $routes;
        $this->checkUrl();
    }
    /**
     * checkUrl
     *
     * @return void
     */
    private function checkUrl()
    {
        if ($this->route !== strtolower($this->route)) {
            http_response_code(301);
            header('location:/derrick/'  . strtolower($this->route));
        }
    }

    private function renderView($templateFileName, $variables = [])
    {
        extract($variables);
        ob_start();
        include __DIR__ . '/../Views/' . $templateFileName;
        return ob_get_clean();
    }

    /**
     * runApp
     *
     * @return void
     */
    public function runApp()
    {
        $routes = $this->routes->getRoutes();
        $checkAction = $routes[$this->route];

        //check if the route and the request type exist
        if (!array_key_exists($this->route, $routes) && !array_key_exists($this->method, $checkAction)) {
            header("location:/derrick/");
            exit();
        }

        $authentication = $this->routes->getAuthenticator();
        $controller = $routes[$this->route][$this->method]['controller'];
        $action = $routes[$this->route][$this->method]['action'];

        $page = $controller->$action();
        $title = $page['title'];

        //check if logged out users are eligible to view the page
        if (isset($routes[$this->route]['login']) && !$authentication->isLoggedIn()) {
            header('location: /derrick/login');
            exit();
            //check if user has permission to view relevant pages
        } else if (isset($routes[$this->route]['permissions']) && !$this->routes->checkPermission($routes[$this->route]['permissions'])) {
            header('location: /derrick/user/dashboard');
            exit();
        } else {
            //check if the page requires dynamic content
            if (isset($page['variables'])) {
                //check if it is an asynchronous request
                if (isset($page['variables']['asynchronous'])) {
                    print_r(json_encode($page['variables']['asynchronous']));
                    die(0);
                }
                $output = $this->renderView($page['template'], $page['variables']);
            } else {
                $output = $this->renderView($page['template']);
            }
            echo $this->renderView('layout.html.php', ['userObject' => $authentication->getUser(), 'loggedIn' => $authentication->isLoggedIn(), 'title' => $title, 'output' => $output]);
        }
    }
}
