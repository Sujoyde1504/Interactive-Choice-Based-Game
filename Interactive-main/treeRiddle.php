<?php
session_start();

// Define riddles and answers
$riddles = [
    ["riddle" => "The more you share, the more it grows.", "answer" => "happiness"],
    ["riddle" => "You can’t see it, but when it's there, it make people shout, cry, and fight.", "answer" => "anger"],
    ["riddle" => "What is stronger than anger, louder than hate, and brighter than fear. ", "answer" => "love"]
];

// Initialize game
if (!isset($_SESSION['lives'])) {
    $_SESSION['lives'] = 5;
    $_SESSION['current'] = 0;
    $_SESSION['riddles'] = $riddles;
    $_SESSION['message'] = "";
}

$current = $_SESSION['current'];
$lives = $_SESSION['lives'];
$message = $_SESSION['message'];
$total = count($_SESSION['riddles']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_answer = strtolower(trim($_POST['answer']));
    $correct_answer = strtolower($_SESSION['riddles'][$current]['answer']);

    if ($user_answer === $correct_answer) {
        $_SESSION['message'] = "Correct! 🌟";
        $_SESSION['current']++;
    } else {
        $_SESSION['lives']--;
        $_SESSION['message'] = "Wrong! ❌ You lost a life.";
    }

    header("Location: treeRiddle.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Banyor the Ancient – Riddles</title>
    <style>
    body {
        margin: 0;
        padding: 0;
        font-family: 'Georgia', serif;
        background: url('https://img.freepik.com/premium-photo/vector-cartoon-forest-with-ancient-tree-with-door-leading-secret-world_760214-6167.jpg') no-repeat center center fixed;
        background-size: cover;
        color: #e0ffe1;
        text-align: center;
        padding: 60px 20px;
        backdrop-filter: blur(2px);
    }

    .tree {
        font-size: 42px;
        font-weight: bold;
        color: #caffc4;
        text-shadow: 0 0 12px #6aff87, 0 0 25px #34a853;
        margin-bottom: 40px;
    }

    .riddle-box {
        background: rgba(0, 40, 20, 0.88);
        padding: 40px 60px;
        border: 3px solid #4ff78d;
        border-radius: 18px;
        box-shadow: 0 0 30px #0a3318;
        display: inline-block;
        max-width: 80%;
        font-size: 20px;
        line-height: 1.6;
        transition: transform 0.2s ease;
    }

    .riddle-box:hover {
        transform: scale(1.02);
    }

    input[type="text"] {
        padding: 14px;
        width: 90%;
        max-width: 600px;
        font-size: 20px;
        border: none;
        border-radius: 5px;
        background: #d4ffe8;
        color: #003322;
        margin-bottom: 14px;
    }

    input[type="submit"] {
        padding: 12px 36px;
        font-size: 20px;
        cursor: pointer;
        background: linear-gradient(to right, #28a745, #43d57d);
        color: white;
        border: none;
        border-radius: 10px;
        transition: background 0.3s, box-shadow 0.3s;
        box-shadow: 0 0 10px #28a745;
    }

    input[type="submit"]:hover {
        background: linear-gradient(to right, #208a3a, #36b56e);
        box-shadow: 0 0 15px #28a745;
    }

    .lives {
        margin-top: 20px;
        font-size: 20px;
        color: #ffb3b3;
        text-shadow: 0 0 5px #ff5555;
    }

    .message {
        margin-top: 14px;
        font-weight: bold;
        font-size: 20px;
        color: #f9ffac;
        text-shadow: 0 0 6px #dbff42;
    }

    .end {
        font-size: 28px;
        margin-top: 40px;
        background: rgba(0, 0, 0, 0.65);
        display: inline-block;
        padding: 35px;
        border-radius: 18px;
        border: 2px solid #55aa77;
        color: #eaffea;
        text-shadow: 0 0 8px #a5ffc2;
    }

    .restart {
        margin-top: 25px;
    }

    a.button {
        padding: 12px 28px;
        background: linear-gradient(to right, #1db36a, #3bf798);
        color: white;
        text-decoration: none;
        border-radius: 10px;
        font-weight: bold;
        font-size: 18px;
        transition: 0.3s ease;
        box-shadow: 0 0 10px #3bf798;
    }

    a.button:hover {
        background: linear-gradient(to right, #178f52, #31d287);
        box-shadow: 0 0 14px #36ff9e;
    }
</style>


</head>
<body>
    <div class="tree">🌳 <b>Banyor the Ancient</b> 🌳</div>

    <?php if ($lives <= 0): ?>
        <div class="end">You have failed the riddles. Banyor is disappointed... 🌫️</div>
        <div class="restart"><a class="button" href="reset2.php">Try Again</a></div>

    <?php elseif ($current >= $total): ?>
        <div class="end">You have proven your wisdom! 🌟<br>Banyor grants you his secret blessing.</div>
        <div class="restart"><a class="button" href="scene4.1.php"> Continue </a></div>

    <?php else: ?>
        <div class="riddle-box">
            <p><b>Riddle <?php echo $current + 1; ?>:</b></p>
            <p><?php echo $_SESSION['riddles'][$current]['riddle']; ?></p>

            <form method="post">
                <input type="text" name="answer" required placeholder="Your answer..."><br>
                <input type="submit" value="Submit Answer">
            </form>

            <div class="message"><?php echo $message; ?></div>
            <div class="lives">❤️ Lives left: <?php echo $lives; ?></div>
        </div>
    <?php endif; ?>
</body>
</html>
