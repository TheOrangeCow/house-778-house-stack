<?php
include "../base/chech.php"; 
include "../base/main.php";
session_start();

include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $questionId = $_POST['question_id'];
    $answer = $_POST['answer'];

    $stmt = $db->prepare("SELECT COUNT(*) FROM questions WHERE id = ?");
    $stmt->execute([$questionId]);
    $exists = $stmt->fetchColumn();
    
    if (!$exists) {
        die("The question you're trying to answer doesn't exist.");
    }

    try {
        $stmt = $db->prepare("INSERT INTO answers (question_id, username, answer) VALUES (?, ?, ?)");
        $stmt->execute([$questionId, $_SESSION['username'], $answer]);

        echo "Your answer has been posted successfully!";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
