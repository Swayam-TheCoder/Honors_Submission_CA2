<?php
require 'database.php';

try {
    $todos = getAllTodos($pdo);
    $todayTodos = getTodayTodos($pdo);
    $stats = getTodoStats($pdo);
} catch (Exception $e) {
    die('Error: ' . $e->getMessage());
}

require 'views/index.html';
?>