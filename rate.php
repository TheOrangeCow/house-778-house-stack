<?php
session_start();
include "db.php";
include "../base/chech2.php";

if (!isset($_SESSION['username'])) {
    die("You must be logged in to vote.");
}

$username = $_SESSION['username'];

$questionId = $_POST['question_id'] ?? null;
$answerId = $_POST['answer_id'] ?? null;
$rating = $_POST['rating'];

if (!$questionId && !$answerId) {
    die("Invalid vote. You must vote on either a question or an answer.");
}

try {
    $db->beginTransaction();

    if ($questionId) {
        $stmt = $db->prepare("SELECT voters FROM questions WHERE id = ?");
        $stmt->execute([$questionId]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $voters = explode(',', $row['voters'] ?? '');

        if (in_array($username, $voters)) {
            $db->rollBack();
            die("You have already voted on this question.");
        }

        $stmt = $db->prepare("UPDATE questions SET rating = rating + ?, voters = CONCAT(voters, ?, ',') WHERE id = ?");
        $stmt->execute([$rating, $username, $questionId]);
    }

    if ($answerId) {
        $stmt = $db->prepare("SELECT voters FROM answers WHERE id = ?");
        $stmt->execute([$answerId]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $voters = explode(',', $row['voters'] ?? '');

        if (in_array($username, $voters)) {
            $db->rollBack();
            die("You have already voted on this answer.");
        }

        $stmt = $db->prepare("UPDATE answers SET rating = rating + ?, voters = CONCAT(voters, ?, ',') WHERE id = ?");
        $stmt->execute([$rating, $username, $answerId]);
    }

    $db->commit();

    header("Location: question.php?id=" . $questionId);
    exit;

} catch (PDOException $e) {
    $db->rollBack();
    die("Error: " . $e->getMessage());
}
?>
