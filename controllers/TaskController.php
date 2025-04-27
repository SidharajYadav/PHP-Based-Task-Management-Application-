<?php
require_once __DIR__ . '/../models/Task.php';
require_once __DIR__ . '/../config/database.php';

class TaskController {
    private $taskModel;
    
    public function __construct() {
        $db = getDatabaseConnection();
        $this->taskModel = new Task($db);
    }
    
    public function index() {
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $perPage = 10;
        $tasks = $this->taskModel->getAll($page, $perPage);
        $totalTasks = $this->taskModel->countAll();
        $totalPages = ceil($totalTasks / $perPage);
        
        require_once __DIR__ . '/../views/tasks/index.php';
    }
    
    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = trim($_POST['title']);
            $description = trim($_POST['description']);
            $priority = $_POST['priority'];
            $due_date = $_POST['due_date'];
            
            $errors = [];
            
            if (empty($title)) {
                $errors[] = 'Title is required';
            }
            
            if (empty($due_date)) {
                $errors[] = 'Due date is required';
            } elseif (strtotime($due_date) < strtotime(date('Y-m-d'))) {
                $errors[] = 'Due date must be in the future';
            }
            
            if (empty($errors)) {
                if ($this->taskModel->create($title, $description, $priority, $due_date)) {
                    header('Location: /');
                    exit;
                } else {
                    $errors[] = 'Failed to create task';
                }
            }
        }
        
        require_once __DIR__ . '/../views/tasks/create.php';
    }
    
    public function edit($id) {
        $task = $this->taskModel->getById($id);
        
        if (!$task) {
            header('Location: /');
            exit;
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = trim($_POST['title']);
            $description = trim($_POST['description']);
            $priority = $_POST['priority'];
            $due_date = $_POST['due_date'];
            $status = $_POST['status'];
            
            $errors = [];
            
            if (empty($title)) {
                $errors[] = 'Title is required';
            }
            
            if (empty($due_date)) {
                $errors[] = 'Due date is required';
            } elseif (strtotime($due_date) < strtotime(date('Y-m-d'))) {
                $errors[] = 'Due date must be in the future';
            }
            
            if (empty($errors)) {
                if ($this->taskModel->update($id, $title, $description, $priority, $due_date, $status)) {
                    header('Location: /');
                    exit;
                } else {
                    $errors[] = 'Failed to update task';
                }
            }
        }
        
        require_once __DIR__ . '/../views/tasks/edit.php';
    }
    
    public function delete($id) {
        if ($this->taskModel->delete($id)) {
            header('Location: /');
            exit;
        }
    }
}
?>