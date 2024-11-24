<?php
include 'includes/db.php';
session_start();


if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}


if (isset($_GET['id'])) {
    $message_id = $_GET['id'];
    $user_id = $_SESSION['user_id'];

   
    try {
        $sql = "DELETE FROM messages WHERE id = :message_id AND user_id = :user_id";
        $stmt = $conn->prepare($sql);
        $stmt->execute(['message_id' => $message_id, 'user_id' => $user_id]);

        
        header("Location: messages.php");
        exit;
    } catch (PDOException $e) {
        echo "Error deleting message: " . $e->getMessage();
    }
} else {
    
    header("Location: messages.php");
    exit;
}
?>
