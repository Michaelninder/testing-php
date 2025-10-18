<?php

$routes = include __DIR__ . '/config/routes.php';

function getRouteByName($name)
{
    global $routes;
    foreach ($routes as $route) {
        if ($route['name'] === $name) {
            return $route;
        }
    }
    return null;
}

function isCurrentRoute($name)
{
    $currentPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $route = getRouteByName($name);
    return $route && $route['path'] === $currentPath;
}