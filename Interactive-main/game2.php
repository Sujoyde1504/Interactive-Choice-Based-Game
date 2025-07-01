<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Hexagon Game Rules</title>
  <style>
    body {
      background-color: #1e1e2f;
      color: #fff;
      font-family: 'Segoe UI', sans-serif;
      padding: 40px;
      line-height: 1.7;
    }
    h1 {
      text-align: center;
      color: #f5b041;
      margin-bottom: 30px;
    }
    .rule-container {
      max-width: 800px;
      margin: 0 auto;
      background: #2c2c3c;
      padding: 30px;
      border-radius: 12px;
      box-shadow: 0 0 15px rgba(255, 255, 255, 0.05);
    }
    ul {
      padding-left: 20px;
    }
    li {
      margin-bottom: 15px;
    }
    a {
      color: #4fc3f7;
      text-decoration: none;
    }
    a:hover {
      text-decoration: underline;
    }
    .btn {
      display: inline-block;
      margin-top: 30px;
      padding: 10px 20px;
      background-color: #4caf50;
      color: #fff;
      text-decoration: none;
      border-radius: 6px;
      transition: background 0.3s;
    }
    .btn:hover {
      background-color: #43a047;
    }
  </style>
</head>
<body>

  <h1>📘 Hexagon Memory Challenge - Rule Book</h1>

  <div class="rule-container">
    <ul>
      <li>🟢 The game board has <strong>19 hexagonal tiles</strong>, each initially showing a number between 1 and 9.</li>
      <li>⏳ You will have <strong>30 seconds</strong> to memorize all numbers on the board.</li>
      <li>🔒 After 30 seconds, the numbers are hidden and replaced with alphabets <strong>(A to S)</strong>.</li>
      <li>🎯 A target number is then revealed. Your goal is to <strong>select 3 adjacent tiles</strong> (in a straight line) whose numbers sum exactly to this target.</li>
      <li>🧠 Use memory, logic, and quick decision-making to win!</li>
      <li>✅ You may only select <strong>3 tiles</strong> – choose wisely!</li>
      <li>📉 Once submitted, your selection is checked for correctness. A success or failure message will be shown.</li>
      <li>🔁 You can restart the game anytime using the “Restart” button.</li>
    </ul>

    <p style="text-align: center;">
        <form method="post" action="reset.php">
            <button type="submit" class="btn">🔙 Start Game</button>
        </form>
    </p>
  </div>

</body>
</html>
