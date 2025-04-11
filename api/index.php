<?php
header("Access-Control-Allow-Origin: *");  // Allow all origins, or replace '*' with specific domains, e.g., "http://cc.localhost"
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");  // Allow specific HTTP methods
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");  // Allow specific headers

require_once './src/Controller/CategoryController.php';
require_once './src/Controller/CourseController.php';
require_once 'configuration.php';

spl_autoload_register(function ($class) {
    $prefix = 'Src\\';
    $base_dir = __DIR__ . '/src/';

    // Does the class use the namespace prefix?
    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        return;
    }

    // Get the relative class name
    $relative_class = substr($class, $len);

    // Replace namespace separators with directory separators, append .php
    $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';

    // If the file exists, require it
    if (file_exists($file)) {
        require $file;
    }
});

$url = $_SERVER['REQUEST_URI'];
$method = $_SERVER['REQUEST_METHOD'];

// Remove query string parameters from the URL for matching
$clean_url = strtok($url, '?'); // Get the base URL without query parameters
$query_string = $_SERVER['QUERY_STRING']; // Get the query string

// Categories routes
if ($clean_url === '/categories' && $method === 'GET') {
    $controller = new Src\Controller\CategoryController();
    return $controller->getCategories();
} 

// Courses routes
elseif ($clean_url === '/courses' && $method === 'GET') {
    // Check for valid category_id in query string and not 'undefined'
    parse_str($query_string, $params); // Parse query string into an associative array
    
    if (isset($params['category_id']) && $params['category_id'] !== 'undefined' && !empty($params['category_id'])) {
        $categoryId = $params['category_id']; // Assign valid category_id
        $controller = new Src\Controller\CourseController();
        $controller->getCourses($categoryId); // Fetch courses for the given category_id
    } else {
        // If no valid category_id, fetch all courses
        $controller = new Src\Controller\CourseController();
        $controller->getCourses();
    }
} 