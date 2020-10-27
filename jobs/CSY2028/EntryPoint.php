<?php

namespace CSY2028;

class EntryPoint
{

    private $routes;
    //type hinting based on the interface in the framework directory
    public function __construct(\CSY2028\Routes $routes)
    {
        $this->routes = $routes;
    }

    public function run()
    {

        $route = ltrim(explode('?', $_SERVER['REQUEST_URI'])[0], '/');
        $routes = $this->routes->getRoutes($route);

        // redirects non-existent URLs
        if (!isset($routes[$route])) {
            header('location: /');
        }
        $method = $_SERVER['REQUEST_METHOD'];

        // redirects all urls that require log in
        if (
            isset($routes[$route]['login'])  && $routes[$route]['login'] == true &&
            !$this->routes->getAuthentication()->isLoggedIn()
        ) {
            header('location: /admin/login/error');
        } else {
            $controller = $routes[$route][$method]['controller'];
            $functionName = $routes[$route][$method]['function'];
            $page = $controller->$functionName();
            $loggedin =   $this->routes->getAuthentication()->isLoggedIn();
            $output = $this->loadTemplate('../templates/' . $page['template'], $loggedin, $page['variables']);
            $title = $page['title'];
            extract($page['variables']);
            require '../templates/layout.html.php';
        }
    }

    public function loadTemplate($fileName, $loggedin, $templateVars)
    {
        extract($templateVars);
        ob_start();
        require $fileName;
        $contents = ob_get_clean();
        return $contents;
    }
}
