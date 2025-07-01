<?php
session_start();

// Define statements
$statements = [
    ["statement" => "Gold is heavier than silver.", "is_true" => true],
    ["statement" => "Humans have 3 lungs.", "is_true" => false],
    ["statement" => "The Great Wall of China is visible from space.", "is_true" => false],
    ["statement" => "Lightning is hotter than the surface of the sun.", "is_true" => true],
    ["statement" => "Bananas grow on trees.", "is_true" => false],
];

// Handle Play Again
if (isset($_POST['play_again'])) {
    unset($_SESSION['index'], $_SESSION['score'], $_SESSION['message']);
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

// Initialize
if (!isset($_SESSION['index'])) {
    $_SESSION['index'] = 0;
    $_SESSION['score'] = 0;
    $_SESSION['message'] = '';
}

// Handle answer
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['answer'])) {
    $player_answer = $_POST['answer'];
    $current = $statements[$_SESSION['index']];
    $is_correct = ($player_answer == 'truth' && $current['is_true']) || ($player_answer == 'lie' && !$current['is_true']);

    if ($is_correct) {
        $_SESSION['score']++;
        $_SESSION['message'] = "✅ Correct!";
    } else {
        $_SESSION['message'] = "❌ Wrong!";
    }

    $_SESSION['index']++;
}

$game_over = $_SESSION['index'] >= count($statements);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Through The Lies</title>
    <style>
        body {
            margin: 0;
            background: linear-gradient(135deg, #2ecc71, #e74c3c);
            font-family: 'Segoe UI', sans-serif;
            color: #fff;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
        .container {
            background-color: rgba(0,0,0,0.85);
            padding: 60px 40px;
            border-radius: 15px;
            width: 80%;
            max-width: 800px;
            text-align: center;
            box-shadow: 0 0 25px rgba(0, 0, 0, 0.5);
        }
        h1 {
            font-size: 48px;
            margin-bottom: 30px;
        }
        p {
            font-size: 26px;
            margin: 20px 0;
        }
        .btn {
            font-size: 24px;
            padding: 15px 40px;
            margin: 20px 15px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            color: white;
            transition: transform 0.2s;
        }
        .btn:hover {
            transform: scale(1.05);
        }
        .truth {
            background-color: #27ae60;
        }
        .lie {
            background-color: #c0392b;
        }
        .message {
            font-size: 28px;
            margin-top: 15px;
        }
        .score {
            font-size: 22px;
            margin-top: 10px;
            color: #f1c40f;
        }
        .play-again {
            background-color: #3498db;
            font-size: 24px;
            padding: 12px 30px;
            margin-top: 30px;
            border-radius: 8px;
            cursor: pointer;
            color: white;
            border: none;
        }
        .play-again:hover {
            background-color: #2980b9;
        }
        .continue {
            display: inline-block;
            background-color: #2ecc71;
            padding: 12px 30px;
            border-radius: 8px;
            font-size: 24px;
            text-decoration: none;
            color: white;
            margin-top: 20px;
        }
        .continue:hover {
            background-color: #27ae60;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Through The Lies</h1>

        <?php if ($game_over): ?>
            <p>Your Score: <?= $_SESSION['score'] ?>/5</p>
            <h2><?= ($_SESSION['score'] >= 3) ? "🎉 You Win!" : "😢 You Lose!" ?></h2>

            <?php if ($_SESSION['score'] >= 3): ?>
                <a href="scene5.php" class="continue">Continue</a><br>
            <?php endif; ?>

            <form method="post">
                <button name="play_again" class="play-again">Play Again</button>
            </form>
        <?php else: ?>
            <p><strong>Statement <?= $_SESSION['index'] + 1 ?> of 5:</strong></p>
            <p>"<?= $statements[$_SESSION['index']]['statement'] ?>"</p>

            <form method="post">
                <button name="answer" value="truth" class="btn truth">Truth</button>
                <button name="answer" value="lie" class="btn lie">Lie</button>
            </form>

            <div class="message"><?= $_SESSION['message'] ?></div>
            <div class="score">Score: <?= $_SESSION['score'] ?></div>
        <?php endif; ?>
    </div>
</body>
</html>
