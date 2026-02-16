<?php

declare(strict_types=1);

namespace Src\Core;

final class Router
{
    private array $routes = [];

    public function add(string $route, callable|array $handler, ?callable $guard = null): void
    {
        $this->routes[$route] = ['handler' => $handler, 'guard' => $guard];
    }

    public function dispatch(string $route): void
    {
        if (!isset($this->routes[$route])) {
            http_response_code(404);
            echo 'Sayfa bulunamadi.';
            return;
        }

        $entry = $this->routes[$route];

        if (is_callable($entry['guard'])) {
            ($entry['guard'])();
        }

        $handler = $entry['handler'];
        if (is_array($handler)) {
            [$class, $method] = $handler;
            $controller = new $class();
            $controller->{$method}();
            return;
        }

        $handler();
    }
}
