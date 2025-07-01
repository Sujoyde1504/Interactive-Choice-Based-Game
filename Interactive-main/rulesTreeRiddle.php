<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Rule Book – Banyor the Ancient</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Georgia', serif;
            background: url('https://img.freepik.com/premium-photo/vector-cartoon-forest-with-ancient-tree-with-door-leading-secret-world_760214-6167.jpg') no-repeat center center fixed;
            background-size: cover;
            color: #e2ffe2;
            text-align: center;
            padding: 60px 20px;
            backdrop-filter: blur(2px);
        }

        .container {
            background: rgba(0, 40, 20, 0.85);
            max-width: 800px;
            margin: auto;
            padding: 40px;
            border-radius: 18px;
            border: 2px solid #3aff91;
            box-shadow: 0 0 30px #145c34;
        }

        h1 {
            font-size: 40px;
            color: #c2ffc8;
            text-shadow: 0 0 12px #5effa3;
            margin-bottom: 20px;
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

        .play-btn {
            margin-top: 30px;
        }

        button {
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

        button:hover {
            background: linear-gradient(to right, #178f52, #31d287);
            box-shadow: 0 0 14px #36ff9e;
        }
    </style>
</head>
<body>

    <div class="container">
        <h1>🌳 Banyor the Ancient – Rule Book</h1>

        <p>Welcome, seeker. You stand before <strong>Banyor</strong>, the wise tree of riddles, hidden deep within the ancient forest.</p>

        <h2>📜 Objective</h2>
        <p>Answer Banyor’s 3 riddles correctly. You have 5 lives. Fail them all, and be lost in the woods forever...</p>

        <h2>🧠 How to Play</h2>
        <ul>
            <li>You will be shown a riddle one at a time.</li>
            <li>Type your answer in the input box below the riddle.</li>
            <li>Answers are not case-sensitive.</li>
            <li>Each wrong answer costs you one life.</li>
            <li>If you lose all 5 lives, the game ends.</li>
        </ul>

    <p style="text-align: center;">
        <form method="post" action="reset2.php">
            <button type="submit" class="btn">🔙 Start Game</button>
        </form>
    </p>
    </div>

</body>
</html>
