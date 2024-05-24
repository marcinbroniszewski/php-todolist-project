<?php

declare(strict_types=1);

namespace Framework;

class Router
{
    private $routes = [];

    public function registerRoute(string $method, string $uri, string $action)
    {
        list($controller, $controllerMethod) = explode('@', $action);

        $this->routes[] = [
            'method' => $method,
            'uri' => $uri,
            'controller' => $controller,
            'controllerMethod' => $controllerMethod
        ];
    }

    public function get(string $path, string $controller)
    {
        $this->registerRoute('GET', $path, $controller);
    }

    public function post(string $path, string $controller)
    {
        $this->registerRoute('POST', $path, $controller);
    }

    public function put(string $path, string $controller)
    {
        $this->registerRoute('PUT', $path, $controller);
    }

    public function delete(string $path, string $controller)
    {
        $this->registerRoute('DELETE', $path, $controller);
    }

    public function route(string $uri, string $method) {
        foreach($this->routes as $route) {
            if ($route['uri'] === $uri && $route['method'] === $method) {
                $controller = 'App\\Controllers\\' . $route['controller'];
                $controllerMethod = $route['controllerMethod'];

                $controllerInstance = new $controller();
                $controllerInstance->$controllerMethod();
                return;
            } else {
                echo '404';
            }
        }
    }
}
