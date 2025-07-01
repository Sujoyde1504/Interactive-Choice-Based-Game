<?php
session_start();

if (isset($_POST['start'])) {
    unset($_SESSION['index'], $_SESSION['score'], $_SESSION['message']);
    header("Location: throughTheLies.php" );
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Through The Lies - Rule Book</title>
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
            background-color: rgba(0, 0, 0, 0.85);
            padding: 50px 40px;
            border-radius: 15px;
            width: 80%;
            max-width: 800px;
            text-align: center;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.6);
        }
        h1 {
            font-size: 48px;
            margin-bottom: 20px;
            color: #f1c40f;
        }
        ul {
            text-align: left;
            font-size: 22px;
            margin-top: 30px;
        }
        ul li {
            margin: 15px 0;
        }
        .start-btn {
            background-color: #3498db;
            padding: 15px 40px;
            font-size: 24px;
            margin-top: 40px;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            color: #fff;
            transition: background 0.3s, transform 0.2s;
        }
        .start-btn:hover {
            background-color: #2980b9;
            transform: scale(1.05);
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Through The Lies</h1>
        <h2>📖 Rule Book</h2>
        <ul>
            <li>🧠 You will be shown 5 real-life statements.</li>
            <li>✅ Some statements are TRUE, some are FALSE (LIES).</li>
            <li>🕹️ Click on <strong>Truth</strong> or <strong>Lie</strong> based on your judgment.</li>
            <li>⭐ You get 1 point for every correct answer.</li>
            <li>🏁 The game continues for 5 rounds — no matter if your answer is right or wrong.</li>
            <li>🎯 Score at least 3 out of 5 to win!</li>
        </ul>
        <form method="post">
            <button name= "start" type="submit" class="start-btn">Start Game</button>
        </form>
    </div>
</body>
</html>
