<?php
class Router {
    private static $routes = [];
    private static $params = [];

    public static function add($method, $path, $handler) {
        self::$routes[] = [
            'method' => $method,
            'path' => $path,
            'handler' => $handler
        ];
    }

    public static function dispatch() {
        $method = $_SERVER['REQUEST_METHOD'];
        $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        
        // Remove base path from URL
        $basePath = dirname($_SERVER['SCRIPT_NAME']);
        if ($basePath !== '/' && $basePath !== '\\') {
            $path = substr($path, strlen($basePath));
        }
        
        // Remove trailing slash
        $path = rtrim($path, '/');
        if (empty($path)) {
            $path = '/';
        }

        foreach (self::$routes as $route) {
            $pattern = self::convertRouteToRegex($route['path']);
            if ($route['method'] === $method && preg_match($pattern, $path, $matches)) {
                array_shift($matches); // Remove full match
                self::$params = $matches;
                return call_user_func_array($route['handler'], $matches);
            }
        }

        // 404 handler
        header("HTTP/1.0 404 Not Found");
        include '../views/404.php';
    }

    private static function convertRouteToRegex($route) {
        // Convert route parameters to regex patterns
        $pattern = preg_replace('/\{([a-zA-Z]+)\}/', '([^/]+)', $route);
        return '#^' . $pattern . '$#';
    }

    public static function getParams() {
        return self::$params;
    }

    // Helper methods for common HTTP methods
    public static function get($path, $handler) {
        self::add('GET', $path, $handler);
    }

    public static function post($path, $handler) {
        self::add('POST', $path, $handler);
    }

    public static function put($path, $handler) {
        self::add('PUT', $path, $handler);
    }

    public static function delete($path, $handler) {
        self::add('DELETE', $path, $handler);
    }
} 