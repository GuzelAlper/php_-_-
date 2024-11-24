<?php
include 'includes/db.php';
session_start();

// Kullanıcı giriş kontrolü
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Mesaj gönderme işlemi
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $content = $_POST['content'];
    $user_id = $_SESSION['user_id'];

    $sql = "INSERT INTO messages (user_id, content, created_at) VALUES (:user_id, :content, NOW())";
    $stmt = $conn->prepare($sql);
    $stmt->execute(['user_id' => $user_id, 'content' => $content]);
}

// Mesajları çekme
$sql = "SELECT messages.*, users.name 
        FROM messages 
        JOIN users ON messages.user_id = users.id 
        ORDER BY created_at DESC";
$stmt = $conn->query($sql);
$messages = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Messages</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Messages</h1>
    <form method="POST">
        <textarea name="content" required placeholder="Write your message here..."></textarea>
        <button type="submit">Post</button>
    </form>
    <hr>
    <?php foreach ($messages as $message): ?>
        <div class="message <?= $message['user_id'] == $_SESSION['user_id'] ? 'own' : '' ?>">
            <strong><?= htmlspecialchars($message['name']) ?>:</strong>
            <?= htmlspecialchars($message['content']) ?>
            <small><?= $message['created_at'] ?></small>
            <?php if ($message['user_id'] == $_SESSION['user_id']): ?>
                <a href="delete.php?id=<?= $message['id'] ?>" onclick="return confirm('Are you sure you want to delete this message?');">Delete</a>
            <?php endif; ?>
        </div>
    <?php endforeach; ?>
</body>
</html>
