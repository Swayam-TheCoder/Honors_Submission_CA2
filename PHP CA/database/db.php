<?php

function getdb() {
    $host = '127.0.0.1';
    $db   = 'todo_app';   
    $user = 'root';       
    $pass = '123456';     
    $charset = 'utf8mb4';
    
    $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ];
    
    try {
        $pdo = new PDO($dsn, $user, $pass, $options);
        return $pdo; 
    } catch (\PDOException $e) {
        die("Database connection failed: " . $e->getMessage());
    }
}