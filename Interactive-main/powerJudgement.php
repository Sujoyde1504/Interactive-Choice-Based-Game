<?php
session_start();

// Handle continue: unset session data and redirect after 2s
if (isset($_POST['continue'])) {
    unset($_SESSION['values']);
    unset($_SESSION['eq1']);
    unset($_SESSION['eq2']);
    unset($_SESSION['eq3']);
    unset($_SESSION['ans1']);
    unset($_SESSION['ans2']);
    unset($_SESSION['ans3']);
    unset($_SESSION['message']);
    echo "<script>
        setTimeout(function() {
            window.location.href = 'scene4.2.php';
        }, 2000);
    </script>";
    echo "<h2 style='color:white; text-align:center; padding-top: 100px;'>Resetting... Redirecting to next scene in 2 seconds</h2>";
    exit;
}

// Reset game manually
if (isset($_POST['reset'])) {
    unset($_SESSION['values']);
    unset($_SESSION['eq1']);
    unset($_SESSION['eq2']);
    unset($_SESSION['eq3']);
    unset($_SESSION['ans1']);
    unset($_SESSION['ans2']);
    unset($_SESSION['ans3']);
    unset($_SESSION['message']);
    header("Location: powerJudgement.php");
    exit;
}

// Generate values once per session
if (!isset($_SESSION['values'])) {
    $r = rand(1, 9);
    $g = rand(1, 9);
    $b = rand(1, 9);
    $_SESSION['values'] = ['r' => $r, 'g' => $g, 'b' => $b];

    $_SESSION['eq1'] = [['r', 2], ['b', 1]]; // R + R + B
    $_SESSION['eq2'] = [['b', 1], ['g', 2]]; // B + G + G
    $_SESSION['eq3'] = [['r', 1], ['b', 1], ['g', 1]]; // R + B + G

    function calcEq($eq, $vals) {
        $sum = 0;
        foreach ($eq as $term) {
            $sum += $vals[$term[0]] * $term[1];
        }
        return $sum;
    }

    $_SESSION['ans1'] = calcEq($_SESSION['eq1'], $_SESSION['values']);
    $_SESSION['ans2'] = calcEq($_SESSION['eq2'], $_SESSION['values']);
    $_SESSION['ans3'] = calcEq($_SESSION['eq3'], $_SESSION['values']);
    $_SESSION['message'] = '';
}

if (isset($_POST['submit'])) {
    $ur = (int)$_POST['red'];
    $ug = (int)$_POST['green'];
    $ub = (int)$_POST['blue'];

    if ($ur == $_SESSION['values']['r'] && $ug == $_SESSION['values']['g'] && $ub == $_SESSION['values']['b']) {
        $_SESSION['message'] = "✅ Correct! Well done, smart thinker.";
    } else {
        $_SESSION['message'] = "❌ Incorrect. Try again!";
    }
}

$eq1 = $_SESSION['eq1'];
$eq2 = $_SESSION['eq2'];
$eq3 = $_SESSION['eq3'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Power Judgement Game</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: radial-gradient(circle at center, #0b3d0b, #001a00);
            color: #e0ffe0;
            text-align: center;
            padding: 60px 20px;
        }

        h1 {
            font-size: 36px;
            color: #9aff9a;
            margin-bottom: 30px;
            text-shadow: 0 0 10px #33ff33;
        }

        .equation {
            font-size: 24px;
            margin: 20px;
        }

        .color-box {
            display: inline-block;
            width: 30px;
            height: 30px;
            border-radius: 4px;
            margin: 0 5px;
        }

        .red { background: #ff4c4c; }
        .green { background: #2aff2a; }
        .blue { background: #4c9bff; }

        .input-section {
            margin-top: 40px;
        }

        input[type="number"] {
            padding: 10px;
            font-size: 18px;
            width: 80px;
            margin: 10px;
            border-radius: 5px;
            border: none;
            outline: none;
        }

        input[type="submit"] {
            padding: 12px 24px;
            background: #00c957;
            color: white;
            font-size: 18px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            margin-top: 20px;
            box-shadow: 0 0 10px #00ff88;
        }

        .message {
            margin-top: 25px;
            font-size: 20px;
            color: #ffff99;
        }

        .reset-btn, .continue-btn {
            margin-top: 30px;
        }

        .reset-btn button,
        .continue-btn button {
            background: #444;
            color: #fff;
            padding: 10px 20px;
            font-size: 16px;
            border-radius: 6px;
            cursor: pointer;
        }

        .continue-btn button {
            background: linear-gradient(to right, #00ff88, #009966);
            color: #000;
            padding: 14px 32px;
            font-size: 18px;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            box-shadow: 0 0 12px #33ff99;
        }
    </style>
</head>
<body>
    <h1>🧠 Power Judgement</h1>
    <p>Find the correct values for each color box (Red, Green, Blue) based on the equations:</p>

    <div class="equation">
        <?= str_repeat('<span class="color-box red"></span>', $eq1[0][1]) ?>
        <?= str_repeat('<span class="color-box blue"></span>', $eq1[1][1]) ?>
        = <?= $_SESSION['ans1'] ?>
    </div>

    <div class="equation">
        <?= str_repeat('<span class="color-box blue"></span>', $eq2[0][1]) ?>
        <?= str_repeat('<span class="color-box green"></span>', $eq2[1][1]) ?>
        = <?= $_SESSION['ans2'] ?>
    </div>

    <div class="equation">
        <?= str_repeat('<span class="color-box red"></span>', $eq3[0][1]) ?>
        <?= str_repeat('<span class="color-box blue"></span>', $eq3[1][1]) ?>
        <?= str_repeat('<span class="color-box green"></span>', $eq3[2][1]) ?>
        = <?= $_SESSION['ans3'] ?>
    </div>

    <form method="post" class="input-section">
        <label>🔴 Red: <input type="number" name="red" required></label>
        <label>🟢 Green: <input type="number" name="green" required></label>
        <label>🔵 Blue: <input type="number" name="blue" required></label><br>
        <input type="submit" name="submit" value="Submit">
    </form>

    <div class="message"><?= $_SESSION['message'] ?? '' ?></div>

    <form method="post" class="reset-btn">
        <button type="submit" name="reset">🔄 Restart Game</button>
    </form>

    <?php if ($_SESSION['message'] === "✅ Correct! Well done, smart thinker.") : ?>
        <form method="post" class="continue-btn">
            <button type="submit" name="continue">✅ Continue</button>
        </form>
    <?php endif; ?>
</body>
</html>
