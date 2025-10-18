<?php

$config = include __DIR__ . '/config/app.php';

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

function config($key, $default = null)
{
    global $config;
    return $config[$key] ?? $default;
}

fucntion returnViewByRouteName($name)
{
    $route = getRouteByName($name);
    if ($route) {
        $viewPath = config('base_view_path') . '/' . $route['file'];
        if (file_exists(__DIR__ . $viewPath)) {
            include __DIR__ . $viewPath;
        } else {
            if (config('debug_mode')) {
                echo "View file not found: " . htmlspecialchars($viewPath);
            }
        }
    } else {
        if (config('debug_mode')) {
            echo "Route not found: " . htmlspecialchars($name);
        }
    }
}

?>