<?php
$host = 'localhost';
$db = 'message_board'; 
$user = 'root';        
$password = '';        

try {
    $conn = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection error: " . $e->getMessage());
}
?>
