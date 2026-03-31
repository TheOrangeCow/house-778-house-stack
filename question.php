<?php
include "../base/chech.php"; 
include "../base/main.php";
session_start();

include 'db.php';

$questionId = $_GET['id'];

$stmt = $db->prepare("SELECT * FROM questions WHERE id = ?");
$stmt->execute([$questionId]);
$question = $stmt->fetch(PDO::FETCH_ASSOC);

$answers = $db->prepare("SELECT * FROM answers WHERE question_id = ?");
$answers->execute([$questionId]);
$answers = $answers->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Question</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://house-778.theorangecow.org/base/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Comfortaa:wght@300..700&display=swap" rel="stylesheet">
    <link rel="icon" href="https://house-778.theorangecow.org/base/icon.ico" type="image/x-icon">
</head>
<body>
    <canvas class="back" id="canvas"></canvas>
    <?php include '../base/sidebar.php'; ?>

    <div class="con">
        <button class="circle-btn" onclick="openNav()">☰</button>  
        <h1><?php echo htmlspecialchars($question['title']); ?></h1>
        <p><?php echo nl2br(htmlspecialchars($question['content'])); ?></p>
        <p>Asked by: <?php echo htmlspecialchars($question['username']); ?></p>
        <p>Rating: <?php echo $question['rating']; ?></p>
        

        
        <h2>Answers</h2>
        <?php foreach ($answers as $answer): ?>
            <div class="answer">
                <div class="vote-section">
                    <form method="POST" action="rate.php" class ="vote-form">
                        <input type="hidden" name="answer_id" value="<?php echo $answer['id']; ?>">
                        <input type="hidden" name="question_id" value="<?php echo $question['id']; ?>">
                        <input type="hidden" name="rating" value="1">
                        <button class="vote-button upvote-button" type="submit"></button>
                    </form>
                    <span class="vote-count"><?php echo $answer['rating']; ?></span>
                    <form method="POST" action="rate.php" class ="vote-form">
                        <input type="hidden" name="answer_id" value="<?php echo $answer['id']; ?>">
                        <input type="hidden" name="question_id" value="<?php echo $question['id']; ?>">
                        <input type="hidden" name="rating" value="-1">
                        <button class="vote-button downvote-button" type="submit"></button>
                    </form>
                </div>

                <div class="answer-content"> 
                    <p><?php echo nl2br(htmlspecialchars($answer['answer'])); ?></p>
                    <p>Answered by: <?php echo htmlspecialchars($answer['username']); ?></p>
                </div>
                <hr>
            </div>  
            <p>Did you find this question helpful?</p>
            <form method="POST" action="rate.php">
                <input type="hidden" name="question_id" value="<?php echo $question['id']; ?>">
                <input type="hidden" name="rating" value="1">
                <button type="submit">Upvote</button>
            </form>
            <span class="vote-count"><?php echo $question['rating']; ?></span>
            <form method="POST" action="rate.php">
                <input type="hidden" name="question_id" value="<?php echo $question['id']; ?>"> 
                <input type="hidden" name="rating" value="-1">
                <button type="submit">Downvote</button>
            </form>

        <?php endforeach; ?>

        <h2>Post Answer</h2>
        <form method="POST" action="post_answer.php">
            <label for="answer">Your Answer: </label><br>
            <input type="hidden" name="question_id" value="<?php echo $questionId; ?>"><br>
            <textarea name="answer" required></textarea><br>
            <input type="submit" value="Post Answer">
        </form>
    </div>

    <script src="https://theme.house-778.theorangecow.org/background.js"></script>
    <script src="https://house-778.theorangecow.org/base/main.js"></script>
    <script src="https://house-778.theorangecow.org/base/sidebar.js"></script>
</body>
</html>
