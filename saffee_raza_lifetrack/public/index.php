<?php
// Start the session
session_start();

// Include configuration and helper files
require_once '../config/config.php';
require_once '../config/database.php';

// Autoload classes from the 'app' folder
spl_autoload_register(function($class) {
    if (file_exists('../app/controllers/' . $class . '.php')) {
        require_once '../app/controllers/' . $class . '.php';
    } elseif (file_exists('../app/models/' . $class . '.php')) {
        require_once '../app/models/' . $class . '.php';
    }
});
function isUserLoggedIn() {
    return isset($_SESSION['user_id']);
}

// Helper function to parse the URL
function parseUrl() {
    // Get the request URI
    $request = $_SERVER['REQUEST_URI'];
    // echo BASE_URL .'-'. $request .'-';

    // Remove the BASE_URL portion from the URI
    $baseUrl = str_replace(BASE_URL, '', $request);
    $baseUrl = rtrim($baseUrl, '/'); // Remove trailing slash from BASE_URL if any
    

    // Remove any query string from the URL
    $request = strtok($baseUrl, '?');

    // Explode the URL into segments
    return explode('/', trim($request, '/'));
}

// Default controller and method
$controllerName = 'DashboardController';
$methodName = 'index';
$params = [];

// Parse the URL
$url = parseUrl();

// print_r($url);
if (!empty($url)) {
    // Set controller from URL (capitalize the first letter)
    if (!empty($url[0])) {
        $controllerName = ucfirst($url[0]) . 'Controller';
        unset($url[0]);
    }

    // Set method from URL, if it exists
    if (isset($url[1])) {
        $methodName = $url[1];
        unset($url[1]);
    }

    // Remaining parts of the URL are treated as parameters
    $params = $url ? array_values($url) : [];
}

// Check if the controller exists
if (file_exists("../app/controllers/$controllerName.php")) {
    require_once "../app/controllers/$controllerName.php";
    $controller = new $controllerName();
    
    // Check if the method exists in the controller
    if (method_exists($controller, $methodName)) {
        // Call the controller method and pass parameters
        call_user_func_array([$controller, $methodName], $params);
    } else {
        echo "Method '$methodName' not found in controller '$controllerName'.";
    }
} else {
    echo "Controller '$controllerName' not found.";
}
