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

function returnViewByRouteName($name)
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

$currentPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$matchedRoute = null;

foreach ($routes as $route) {
    if ($route['path'] === $currentPath) {
        $matchedRoute = $route;
        break;
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Simple Routing Test</title>
</head>
<body>
    <nav>
        <a href="/home">Home</a> |
        <a href="/about">About</a> |
        <a href="/contact">Contact</a>
    </nav>
    <hr>
    <main>
        <?php
        if ($matchedRoute) {
            returnViewByRouteName($matchedRoute['name']);
        } else {
            http_response_code(404);
            echo "<h1>404 - Not Found</h1>";
        }
        ?>
    </main>
    <hr>
    <footer>
        <p>&copy; <?php echo date('Y'); ?> My Simple Routing Test</p>
    </footer>
</body>
</html>