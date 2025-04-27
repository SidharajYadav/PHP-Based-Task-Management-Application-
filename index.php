<?php
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/controllers/TaskController.php';

// Simple router
$request = $_SERVER['REQUEST_URI'];
$request = str_replace('/task-manager', '', $request); // Remove if using subdirectory

$taskController = new TaskController();

switch ($request) {
    case '/':
    case '':
    case '/tasks':
        $taskController->index();
        break;
    case '/tasks/create':
        $taskController->create();
        break;
    case (preg_match('/^\/tasks\/edit\/(\d+)$/', $request, $matches) ? true : false):
        $taskController->edit($matches[1]);
        break;
    case (preg_match('/^\/tasks\/delete\/(\d+)$/', $request, $matches) ? true : false):
        $taskController->delete($matches[1]);
        break;
    default:
        http_response_code(404);
        echo '404 Not Found';
        break;
}
?>