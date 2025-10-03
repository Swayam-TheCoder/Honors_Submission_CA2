<?php
require 'database.php';

if (isset($_POST['submit'])) {
    $title = $_POST['title'] ?? '';
    $due_date = $_POST['due_date'] ?? '';
    $errors = validateTodoInput($title, $due_date);
    
    if (empty($errors)) {
        try {
            createTodo($pdo, trim($title), $due_date);
            header("Location: index.php");
            exit();
        } catch (Exception $e) {
            $error = $e->getMessage();
        }
    } else {
        $error = implode(", ", $errors);
    }
}

require "views/create.html";