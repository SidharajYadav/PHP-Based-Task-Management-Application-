<?php
class Task {
    private $conn;
    
    public function __construct($db) {
        $this->conn = $db;
    }
    
    public function create($title, $description, $priority, $due_date) {
        $query = "INSERT INTO tasks (title, description, priority, due_date) VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ssss", $title, $description, $priority, $due_date);
        
        return $stmt->execute();
    }
    
    public function getAll($page = 1, $perPage = 10) {
        $offset = ($page - 1) * $perPage;
        $query = "SELECT * FROM tasks ORDER BY due_date ASC LIMIT ?, ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ii", $offset, $perPage);
        $stmt->execute();
        
        return $stmt->get_result();
    }
    
    public function getById($id) {
        $query = "SELECT * FROM tasks WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        
        return $stmt->get_result()->fetch_assoc();
    }
    
    public function update($id, $title, $description, $priority, $due_date, $status) {
        $query = "UPDATE tasks SET title = ?, description = ?, priority = ?, due_date = ?, status = ? WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("sssssi", $title, $description, $priority, $due_date, $status, $id);
        
        return $stmt->execute();
    }
    
    public function delete($id) {
        $query = "DELETE FROM tasks WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id);
        
        return $stmt->execute();
    }
    
    public function countAll() {
        $query = "SELECT COUNT(*) as total FROM tasks";
        $result = $this->conn->query($query);
        return $result->fetch_assoc()['total'];
    }
}
?>