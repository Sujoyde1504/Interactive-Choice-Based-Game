<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Power Judgement – Rule Book</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Georgia', serif;
            background: radial-gradient(circle, #0d2e0d, #000);
            color: #e2ffe2;
            text-align: center;
            padding: 60px 20px;
        }

        .container {
            background: rgba(0, 40, 20, 0.9);
            max-width: 800px;
            margin: auto;
            padding: 40px;
            border-radius: 18px;
            border: 2px solid #3aff91;
            box-shadow: 0 0 30px #145c34;
        }

        h1 {
            font-size: 40px;
            color: #b3ffb3;
            text-shadow: 0 0 12px #5effa3;
            margin-bottom: 30px;
        }

        h2 {
            color: #f5ffba;
            margin-top: 20px;
        }

        p, li {
            font-size: 18px;
            line-height: 1.6;
            margin-bottom: 10px;
        }

        ul {
            list-style: square;
            text-align: left;
            margin: 0 auto;
            max-width: 600px;
        }

        .start-btn {
            margin-top: 35px;
        }

        a.button {
            padding: 14px 32px;
            background: linear-gradient(to right, #00c957, #30ffaf);
            color: white;
            text-decoration: none;
            border-radius: 10px;
            font-weight: bold;
            font-size: 20px;
            transition: 0.3s ease;
            box-shadow: 0 0 12px #3bf798;
        }

        a.button:hover {
            background: linear-gradient(to right, #178f52, #31d287);
            box-shadow: 0 0 16px #36ff9e;
        }
    </style>
</head>
<body>

    <div class="container">
        <h1>🧩 Power Judgement – Rule Book</h1>

        <p><strong>Welcome to Power Judgement!</strong><br>
        A visual logic game where numbers hide behind colors. Use your mind, judge the patterns, and reveal the truth behind the power of colors.</p>

        <h2>🎯 Objective</h2>
        <p>Find the hidden values of 🔴 Red, 🟢 Green, and 🔵 Blue using the given color equations.</p>

        <h2>📜 How to Play</h2>
        <ul>
            <li>Each color (Red, Green, Blue) represents a secret number between 1–9.</li>
            <li>You'll be shown 3 different color-based equations with total values.</li>
            <li>Your task is to deduce the correct value for each color based on the equations.</li>
            <li>Submit your guess for Red, Green, and Blue.</li>
            <li>If your guess is correct, you win. Otherwise, try again!</li>
        </ul>

        <div class="start-btn">
            <a href="powerJudgement.php" class="button">🎮 Start Game</a>
        </div>
    </div>

</body>
</html>
