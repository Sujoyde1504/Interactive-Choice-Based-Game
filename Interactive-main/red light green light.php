<?php
session_start();

if (!isset($_SESSION['start_time'])) {
    $_SESSION['start_time'] = time();
    $_SESSION['word_count'] = 0;
    $_SESSION['game_over'] = false;
    $_SESSION['text'] = '';
    $_SESSION['light'] = 'green';
}

// Calculate time left
$timeLeft = max(0, 240 - (time() - $_SESSION['start_time']));
if ($timeLeft <= 0) {
    $_SESSION['game_over'] = true;
}

// Switch lights randomly every 5 to 10 seconds
if (!isset($_SESSION['next_switch']) || time() >= $_SESSION['next_switch']) {
    $_SESSION['light'] = ($_SESSION['light'] === 'green') ? 'red' : 'green';
    $_SESSION['next_switch'] = time() + rand(5, 10);
}

// Handle text submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !$game_over) {
    $typedText = trim($_POST['text'] ?? '');
    $wordCount = str_word_count($typedText);

    if ($_SESSION['light'] === 'red') {
        $_SESSION['game_over'] = true;
    } else {
        $_SESSION['word_count'] = $wordCount;
        $_SESSION['text'] = $typedText;
        if ($wordCount >= 40) {
            $_SESSION['game_over'] = true;
        }
    }
}

$game_over = $_SESSION['game_over'];
$light = $_SESSION['light'];
$text = $_SESSION['text'];
$wordCount = $_SESSION['word_count'];
?>
<!DOCTYPE html>
<html>
<head>
    <title>Red Light Green Light Typing</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: radial-gradient(ellipse at top left, #2e003e, #1c002a);
            color: white;
            text-align: center;
            padding: 40px;
        }
        textarea {
            width: 80%;
            height: 150px;
            font-size: 16px;
            padding: 10px;
            border: 3px solid #888;
            border-radius: 10px;
            background-color: #1a1a2e;
            color: white;
        }
        .light {
            width: 150px;
            height: 150px;
            margin: 20px auto;
            border-radius: 50%;
            background-color: <?= $light === 'green' ? '#00ff00' : '#ff0000' ?>;
            box-shadow: 0 0 25px <?= $light === 'green' ? '#00ff00' : '#ff0000' ?>, 0 0 80px <?= $light === 'green' ? '#00ff00' : '#ff0000' ?>;
            transition: background-color 0.5s, box-shadow 0.5s;
        }
        .timer {
            font-size: 24px;
            color: #ffcc00;
        }
        .status {
            margin-top: 20px;
            font-size: 18px;
        }
    </style>
    <script>
        let timeLeft = <?= $timeLeft ?>;
        function updateTimer() {
            if (timeLeft <= 0) return;
            document.getElementById("timer").innerText = "⏳ Time Left: " + timeLeft + "s";
            timeLeft--;
            setTimeout(updateTimer, 1000);
        }
        window.onload = updateTimer;
    </script>
</head>
<body>
    <h1>🚦 Red Light Green Light Typing Challenge</h1>

    <div class="light"></div>
    <div class="timer" id="timer"></div>

    <?php if ($game_over): ?>
        <?php if ($wordCount >= 40): ?>
            <h2>🎉 Victory! You typed <?= $wordCount ?> words.</h2>
        <?php else: ?>
            <h2>❌ Game Over! Light was red or time ran out.</h2>
            <p>You typed <?= $wordCount ?> words.</p>
        <?php endif; ?>
        <form method="post" action="">
            <?php session_destroy(); ?>
            <button type="submit">🔄 Restart</button>
        </form>
    <?php else: ?>
        <form method="post">
            <textarea name="text" placeholder="Start typing your 40-word paragraph here..." autofocus><?= htmlspecialchars($text) ?></textarea>
            <br>
            <button type="submit">Submit</button>
        </form>
        <div class="status">Words typed: <?= $wordCount ?> / 40</div>
        <div class="status">Current light: <strong><?= strtoupper($light) ?></strong></div>
    <?php endif; ?>
</body>
</html>
