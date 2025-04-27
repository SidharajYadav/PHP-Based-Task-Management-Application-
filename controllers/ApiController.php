<?php
require_once __DIR__ . '/../models/Task.php';
require_once __DIR__ . '/../config/database.php';

class ApiController {
    private $taskModel;
    
    public function __construct() {
        $db = getDatabaseConnection();
        $this->taskModel = new Task($db);
    }
    
    public function handleRequest() {
        header('Content-Type: application/json');
        
        $method = $_SERVER['REQUEST_METHOD'];
        $request = explode('/', trim($_SERVER['PATH_INFO'],'/'));
        $input = json_decode(file_get_contents('php://input'), true);
        
        switch ($method) {
            case 'GET':
                if (isset($request[0]) {
                    $this->getTask($request[0]);
                } else {
                    $this->getAllTasks();
                }
                break;
            case 'POST':
                $this->createTask($input);
                break;
            case 'PUT':
                if (isset($request[0])) {
                    $this->updateTask($request[0], $input);
                }
                break;
            case 'DELETE':
                if (isset($request[0])) {
                    $this->deleteTask($request[0]);
                }
                break;
            default:
                http_response_code(405);
                echo json_encode(['error' => 'Method Not Allowed']);
        }
    }
    
    private function getAllTasks() {
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $perPage = 10;
        $result = $this->taskModel->getAll($page, $perPage);
        
        $tasks = [];
        while ($row = $result->fetch_assoc()) {
            $tasks[] = $row;
        }
        
        echo json_encode([
            'data' => $tasks,
            'meta' => [
                'page' => $page,
                'per_page' => $perPage,
                'total' => $this->taskModel->countAll()
            ]
        ]);
    }
    
    private function getTask($id) {
        $task = $this->taskModel->getById($id);
        
        if ($task) {
            echo json_encode($task);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Task not found']);
        }
    }
    
    private function createTask($data) {
        $errors = $this->validateTaskData($data);
        
        if (!empty($errors)) {
            http_response_code(400);
            echo json_encode(['errors' => $errors]);
            return;
        }
        
        $success = $this->taskModel->create(
            $data['title'],
            $data['description'] ?? null,
            $data['priority'],
            $data['due_date']
        );
        
        if ($success) {
            http_response_code(201);
            echo json_encode(['message' => 'Task created successfully']);
        } else {
            http_response_code(500);
            echo json_encode(['error' => 'Failed to create task']);
        }
    }
    
    private function updateTask($id, $data) {
        $task = $this->taskModel->getById($id);
        
        if (!$task) {
            http_response_code(404);
            echo json_encode(['error' => 'Task not found']);
            return;
        }
        
        $errors = $this->validateTaskData($data);
        
        if (!empty($errors)) {
            http_response_code(400);
            echo json_encode(['errors' => $errors]);
            return;
        }
        
        $success = $this->taskModel->update(
            $id,
            $data['title'],
            $data['description'] ?? null,
            $data['priority'],
            $data['due_date'],
            $data['status']
        );
        
        if ($success) {
            echo json_encode(['message' => 'Task updated successfully']);
        } else {
            http_response_code(500);
            echo json_encode(['error' => 'Failed to update task']);
        }
    }
    
    private function deleteTask($id) {
        $task = $this->taskModel->getById($id);
        
        if (!$task) {
            http_response_code(404);
            echo json_encode(['error' => 'Task not found']);
            return;
        }
        
        $success = $this->taskModel->delete($id);
        
        if ($success) {
            echo json_encode(['message' => 'Task deleted successfully']);
        } else {
            http_response_code(500);
            echo json_encode(['error' => 'Failed to delete task']);
        }
    }
    
    private function validateTaskData($data) {
        $errors = [];
        
        if (empty($data['title'])) {
            $errors[] = 'Title is required';
        }
        
        if (empty($data['priority']) || !in_array($data['priority'], ['Low', 'Medium', 'High'])) {
            $errors[] = 'Priority must be Low, Medium, or High';
        }
        
        if (empty($data['due_date'])) {
            $errors[] = 'Due date is required';
        } elseif (strtotime($data['due_date']) < strtotime(date('Y-m-d'))) {
            $errors[] = 'Due date must be in the future';
        }
        
        if (isset($data['status']) && !in_array($data['status'], ['Pending', 'Completed'])) {
            $errors[] = 'Status must be Pending or Completed';
        }
        
        return $errors;
    }
}
?>