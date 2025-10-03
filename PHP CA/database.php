<?php

require_once 'database/db.php';    
require_once 'classes/class.php';  

$pdo = getdb();


function createTodo($pdo, $title, $dueDate) {
    try {
        $stmt = $pdo->prepare("INSERT INTO todos (title, due_date, status) VALUES (?, ?, 0)");
        return $stmt->execute([$title, $dueDate]);
    } catch (PDOException $e) {
        throw new Exception("Error creating todo: " . $e->getMessage());
    }
}

function getAllTodos($pdo) {
    try {
        $stmt = $pdo->query("SELECT * FROM todos ORDER BY due_date ASC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        throw new Exception("Error fetching todos: " . $e->getMessage());
    }
}

function getTodoById($pdo, $id) {
    try {
        $stmt = $pdo->prepare("SELECT * FROM todos WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        throw new Exception("Error fetching todo: " . $e->getMessage());
    }
}

function markTodoComplete($pdo, $id) {
    try {
        $stmt = $pdo->prepare("UPDATE todos SET status = 1 WHERE id = ?");
        return $stmt->execute([$id]);
    } catch (PDOException $e) {
        throw new Exception("Error updating todo: " . $e->getMessage());
    }
}

function deleteTodo($pdo, $id) {
    try {
        $stmt = $pdo->prepare("DELETE FROM todos WHERE id = ?");
        return $stmt->execute([$id]);
    } catch (PDOException $e) {
        throw new Exception("Error deleting todo: " . $e->getMessage());
    }
}

function getPendingTodos($pdo) {
    try {
        $stmt = $pdo->query("SELECT * FROM todos WHERE status = 0 ORDER BY due_date ASC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        throw new Exception("Error fetching pending todos: " . $e->getMessage());
    }
}

function getCompletedTodos($pdo) {
    try {
        $stmt = $pdo->query("SELECT * FROM todos WHERE status = 1 ORDER BY due_date ASC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        throw new Exception("Error fetching completed todos: " . $e->getMessage());
    }
}

function getTodoStats($pdo) {
    $all = getAllTodos($pdo);
    $pending = getPendingTodos($pdo);
    $completed = getCompletedTodos($pdo);
    
    return [
        'total' => count($all),
        'pending' => count($pending),
        'completed' => count($completed),
        'completion_rate' => count($all) > 0 ? round((count($completed) / count($all)) * 100, 2) : 0
    ];
}

function validateTodoInput($title, $dueDate) {
    $errors = [];
    
    if (empty(trim($title))) {
        $errors[] = "Title cannot be empty";
    }
    
    if (empty($dueDate)) {
        $errors[] = "Due date cannot be empty";
    } else if (strtotime($dueDate) < strtotime('today')) {
        $errors[] = "Due date cannot be in the past";
    }
    
    return $errors;
}

function updateTodo($pdo, $id, $title, $dueDate) {
    try {
        $stmt = $pdo->prepare("UPDATE todos SET title = ?, due_date = ? WHERE id = ?");
        return $stmt->execute([$title, $dueDate, $id]);
    } catch (PDOException $e) {
        throw new Exception("Error updating todo: " . $e->getMessage());
    }
}

function getTodayTodos($pdo) {
    try {
        $today = date('Y-m-d');
        $stmt = $pdo->prepare("SELECT * FROM todos WHERE due_date = ? ORDER BY status ASC, id DESC");
        $stmt->execute([$today]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        throw new Exception("Error fetching today's todos: " . $e->getMessage());
    }
}


?>