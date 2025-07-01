<?php
session_start();

function generateQuestion() {
    $num1 = mt_rand(5, 20);
    $num2 = mt_rand(2, 10);
    $num3 = mt_rand(1, 5);
    $ops = ['+', '-', '*'];
    $op1 = $ops[mt_rand(0, count($ops) - 1)];
    $op2 = $ops[mt_rand(0, count($ops) - 1)];
    $question = "$num1 $op1 $num2 $op2 $num3";
    $answer = eval("return $question;");
    return [
        'q' => $question,
        'a' => $answer
    ];
}

// Start or reset game
if (!isset($_SESSION['points']) || isset($_POST['restart'])) {
    $_SESSION['points'] = 0;
    $_SESSION['question'] = generateQuestion();
    $_SESSION['start_time'] = time();
    $_SESSION['message'] = '';
}
if (isset($_POST['continue'])) {
    unset($_SESSION['points']);
    unset($_SESSION['question']);
    unset($_SESSION['start_time']);
    unset($_SESSION['message']);
    header("Location: g.php");
    exit;
}


// Timer logic
$points = $_SESSION['points'];
$hasWon = $points >= 3;

$timeLeft = 30 - (time() - $_SESSION['start_time']);
if ($timeLeft <= 0 && !$hasWon) {
    if ($_SESSION['points'] > 0) {
        $_SESSION['points']--;
    }
    $_SESSION['message'] = "⏰ Time's up! -1 point.";
    $_SESSION['question'] = generateQuestion();
    $_SESSION['start_time'] = time();
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

// Answer submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['answer']) && !$hasWon) {
    $userAnswer = intval($_POST['answer']);
    $correctAnswer = $_SESSION['question']['a'];
    if ($userAnswer === $correctAnswer) {
        $_SESSION['points']++;
        $_SESSION['message'] = "✅ Correct! +1 point.";
    } else {
        if ($_SESSION['points'] > 0) {
            $_SESSION['points']--;
        }
        $_SESSION['message'] = "❌ Incorrect! -1 point.";
    }
    $_SESSION['question'] = generateQuestion();
    $_SESSION['start_time'] = time();
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

$question = $_SESSION['question']['q'];
$message = $_SESSION['message'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Quick Math Duel</title>
        <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(to bottom, #1d0033, #2e0066);
            color: #fff;
            text-align: center;
            margin: 0;
            padding: 0;
            overflow: hidden;
            position: relative;
            min-height: 100vh;
            z-index: 0;
        }



        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 200%;
            height: 200%;
            background-image: url('https://static.vecteezy.com/system/resources/previews/044/229/303/non_2x/starry-night-sky-space-seamless-pattern-galaxy-shiny-stars-background-fabric-seamless-print-or-textile-background-wrapping-paper-space-pattern-or-wallpaper-with-comet-glowing-constellations-vector.jpg');
            background-repeat: repeat;
            background-size: cover;
            animation: moveStars 60s linear infinite;
            z-index: -1;
            opacity: 0.9; /* optional: for soft overlay */
        }

        /* Smooth starry movement */
        @keyframes moveStars {
            from {
                transform: translate(0, 0);
            }
            to {
                transform: translate(-50%, -50%);
            }
        }


        .box {
            position: relative;
            z-index: 1;
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(6px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 15px;
            padding: 30px;
            margin: 50px auto;
            width: 80%;
            max-width: 500px;
            font-size: 24px;
            box-shadow: 0 0 15px #bb86fc;
        }

        h1 {
            font-size: 40px;
            color: #e0aaff;
            text-shadow: 0 0 10px #bb86fc;
            margin-top: 30px;
            z-index: 1;
            position: relative;
        }

        input[type=number] {
            padding: 12px;
            font-size: 18px;
            border-radius: 5px;
            border: none;
            width: 120px;
            outline: none;
            box-shadow: 0 0 10px #9a4dff;
        }

        button {
            padding: 10px 25px;
            font-size: 16px;
            margin-top: 15px;
            border-radius: 5px;
            border: none;
            background: #9a4dff;
            color: #fff;
            cursor: pointer;
            transition: background 0.3s ease;
            box-shadow: 0 0 10px #bb86fc;
        }

        button:hover {
            background: #7e2fff;
        }

        #timer {
            font-size: 20px;
            margin-bottom: 15px;
            color: #ffccff;
            text-shadow: 0 0 5px #ff99ff;
        }

        p {
            font-size: 20px;
            margin: 10px 0;
        }

        form {
            margin-top: 20px;
        }
    </style>

    <script>
        let timeLeft = <?= $timeLeft ?>;
        let hasWon = <?= $hasWon ? 'true' : 'false' ?>;

        function updateTimer() {
            if (hasWon || timeLeft <= 0) return;
            document.getElementById("timer").innerText = "⏳ Time left: " + timeLeft + "s";
            timeLeft--;
            setTimeout(updateTimer, 1000);
        }
        window.onload = updateTimer;
    </script>
</head>
<body>
    <h1>🧠 Quick Math Duel</h1>
    <div class="box">
        <div id="timer">⏳</div>
        <p><strong>Points:</strong> <?= $points ?></p>

        <?php if ($hasWon): ?>
            <h2>🎉 You Win!</h2>
            <form method="post">
                <button type="submit" name="continue">Continue</button>
            </form>
        <?php else: ?>
            <p><strong>Question:</strong> <?= $question ?> = ?</p>
            <form method="post">
                <input type="number" name="answer" required />
                <button type="submit">Submit</button>
            </form>
            <p><?= $message ?></p>
        <?php endif; ?>
    </div>
</body>
</html>
