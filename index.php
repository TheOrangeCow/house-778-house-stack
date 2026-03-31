<?php
include "../base/chech.php"; 
include "../base/main.php";
include "../base/chech2.php";
session_start();

include 'db.php';

$questions = $db->query("SELECT * FROM questions ORDER BY rating DESC")->fetchAll(PDO::FETCH_ASSOC);

?>



<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>House stack</title>
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
        <div class= "con">
            <button class="circle-btn" onclick = "openNav()">☰</button>  
            <h1>Welcome, <?php echo $_SESSION['username']; ?> to house stack</h1>
            <a href="post_question.php">Post a Question</a>
            <h2>Questions</h2>
        
            <?php foreach ($questions as $question): ?>
                <div>
                    <h3><a href="question.php?id=<?php echo $question['id']; ?>"><?php echo $question['title']; ?></a></h3>
                    <p>Asked by: <?php echo $question['username']; ?></p>
                    <p>Rating: <?php echo $question['rating']; ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </body>
    <script src="https://theme.house-778.theorangecow.org/background.js"></script>
    <script src="https://house-778.theorangecow.org/base/main.js"></script>
    <script src="https://house-778.theorangecow.org/base/sidebar.js"></script>>
</html>

