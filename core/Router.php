<?php
namespace app\core;

use app\core\exception\NotFoundException;

class Router
{
    public $request;
    public $response;
    private $routeMap = [];

    /**
     * @param $request
     * @param $response
     */
    public function __construct($request, $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

    public function get($url,$callback)
    {
        $this->routeMap['get'][$url] = $callback;
    }

    public function post($url,$callback)
    {
        $this->routeMap['post'][$url] = $callback;
    }

    /**
     * @throws NotFoundException
     */
    public function getCallback()
    {
        $url = $this->request->getUrl();
        $method = $this->request->getMethod();
        // Trim slashes
        $url = trim($url, '/');

        // Get all routes for current request method
        $routes = $this->getRouteMap($method);
        $routeParams = false;

        // Start iterating registered routes
        foreach ($routes as $route => $callback) {
            // Trim slashes
            $route = trim($route, '/');
            $routeNames = [];

            if (!$route) {
                continue;
            }

            // Find all route names from route and save in $routeNames
            if (preg_match_all('/\{(\w+)(:[^}]+)?}/', $route, $matches)) {
                $routeNames = $matches[1];
            }

            // Convert route name into regex pattern
            $routeRegex = "@^" . preg_replace_callback('/\{\w+(:([^}]+))?}/', function ($m) {
                    return isset($m[2]) ? "({$m[2]})" : '(\w+)';
                }, $route) . "$@";

            // Test and match current route against $routeRegex
            if (preg_match_all($routeRegex, $url, $valueMatches)) {
                $values = [];
                for ($i = 1; $i < count($valueMatches); $i++) {
                    $values[] = $valueMatches[$i][0];
                }
                $routeParams = array_combine($routeNames, $values);

                $this->request->setRouteParams($routeParams);
                return $callback;
            }
        }
        return false;
    }

    /**
     * @throws NotFoundException
     */
    public function resolve()
    {
        $method = $this->request->getMethod();
        $url = $this->request->getUrl();
        $callback = $this->routeMap[$method][$url] ?? false;

        if (!$callback) {

            $callback = $this->getCallback();

            if ($callback === false) {
                throw new NotFoundException();
            }
        }
        if (is_string($callback)) {
            return $this->renderView($callback);
        }
        if (is_array($callback)) {
            /**
            * @var $controller
            */
            $controller = new $callback[0];
            $controller->action = $callback[1];
            Application::$app->controller = $controller;
            $middlewares = $controller->getMiddlewares();
            foreach ($middlewares as $middleware) {
                $middleware->execute();
            }
            $callback[0] = $controller;
        }
        return call_user_func($callback, $this->request, $this->response);
    }

    /**
     * @param string $view
     * @param array $params
     * @return array|false|string|string[]
     */
    public function renderView(string $view, array $params = [])
    {
        return Application::$app->view->renderView($view, $params);
    }

    /**
     * @param string $view
     * @param array $params
     * @return mixed
     */
    public function renderViewOnly(string $view, array $params = [])
    {
        return Application::$app->view->renderViewOnly($view, $params);
    }

    private function getRouteMap($method)
    {
        return $this->routeMap[$method] ?? [];
    }
}