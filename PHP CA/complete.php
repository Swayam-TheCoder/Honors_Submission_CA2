<?php
require 'database.php';

if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    
    try {

        $todo = getTodoById($pdo, $id);
        if (!$todo) {
            die("Todo not found");
        }

        if ($todo['status'] == 1) {
            die("Todo is already completed");
        }
        
        markTodoComplete($pdo, $id);
        header("Location: index.php");
        exit();
    } catch (Exception $e) {
        die("Error: " . $e->getMessage());
    }
}

header("Location: index.php");
exit();