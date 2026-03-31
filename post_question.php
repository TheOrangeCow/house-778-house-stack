<?php
include "../base/chech.php"; 
include "../base/main.php";
include "../base/chech2.php"; 
session_start(); 

include 'db.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $stmt = $db->prepare("INSERT INTO questions (username, title, content) VALUES (?, ?, ?)");
    $stmt->execute([$_SESSION['username'], $_POST['title'], $_POST['content']]);

    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Post Question</title>
</head>
<body>
    <h1>Post a Question</h1>
    <form method="POST" action="post_question.php">
        <label for="title">Title: </label><br>
        <input type="text" name="title" required><br>
        <label for="content">Content: </label><br>
        <textarea name="content" required></textarea><br>
        <input type="submit" value="Post Question">
    </form>
</body>
</html>
