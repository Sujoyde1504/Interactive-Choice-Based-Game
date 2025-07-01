<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Rule Book</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Georgia', serif;
            background: linear-gradient(to bottom right, #2b1055, #7597de);
            color: white;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            background-image: url('https://static.vecteezy.com/system/resources/previews/044/229/303/non_2x/starry-night-sky-space-seamless-pattern-galaxy-shiny-stars-background-fabric-seamless-print-or-textile-background-wrapping-paper-space-pattern-or-wallpaper-with-comet-glowing-constellations-vector.jpg');
            background-size: cover;
            background-position: center;
        }

        .container {
            background: rgba(0, 0, 0, 0.7);
            border-radius: 20px;
            padding: 30px;
            width: 80%;
            max-width: 600px;
            text-align: center;
            box-shadow: 0 0 15px rgba(255, 255, 255, 0.3);
        }

        h1 {
            margin-bottom: 20px;
            font-size: 2em;
            color: #ffdb4d;
        }

        ul {
            text-align: left;
            padding-left: 20px;
        }

        li {
            margin-bottom: 10px;
        }

        .btn {
            margin-top: 20px;
            padding: 12px 25px;
            background: #8e44ad;
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 1em;
            cursor: pointer;
            transition: background 0.3s;
        }

        .btn:hover {
            background: #a569bd;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>📘 Game Rule Book</h1>
    <ul>
        <li>🧠 Read each question carefully.</li>
        <li>⏱️ You’ll have 30 seconds per question.</li>
        <li>✅ Every correct answer gives you 1 point.</li>
        <li>❌ Negative marking for wrong answers or times run out.</li>
        <li>🚀 Try to score 3 points to win the game</li>
    </ul>

    <form action="Quick Math Duel.php" method="post">
        <button type="submit" class="btn">🚀 Start Game</button>
    </form>
</div>

</body>
</html>
