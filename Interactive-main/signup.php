<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup</title>
  <style>
    body {
      margin: 0;
      padding: 0;
      font-family: 'Georgia', serif;
      background: linear-gradient(to bottom right, #2b1055, #7597de);
      color: #fff;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }

    .container {
      background: rgba(255, 255, 255, 0.05);
      border: 2px solid rgba(255, 255, 255, 0.2);
      border-radius: 15px;
      backdrop-filter: blur(15px);
      box-shadow: 0 0 40px rgba(0, 0, 0, 0.5);
      padding: 30px;
      width: 320px;
      animation: fadeIn 1s ease-in-out;
    }

    h2 {
      text-align: center;
      margin-bottom: 20px;
      font-size: 28px;
      color: #ffd700;
      text-shadow: 1px 1px 3px #000;
    }

    input[type="text"], input[type="email"], input[type="password"] {
      width: 100%;
      padding: 12px 15px;
      margin: 10px -10px;
      border: none;
      border-radius: 10px;
      background: rgba(255, 255, 255, 0.1);
      color: #fff;
      font-size: 16px;
      outline: none;
      transition: background 0.3s ease;
    }

    input[type="text"]:focus,
    input[type="email"]:focus,
    input[type="password"]:focus {
      background: rgba(255, 255, 255, 0.2);
    }
    ::placeholder {
            color: rgba(3, 23, 65, 0.24);
            opacity: 1; /* Firefox */
                }

    button {
      width: 100%;
      padding: 12px;
      background: linear-gradient(to right, #d4af37, #b8860b);
      color: #000;
      font-weight: bold;
      border: none;
      border-radius: 10px;
      cursor: pointer;
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    button:hover {
      transform: scale(1.05);
      box-shadow: 0 0 15px #fff;
    }

    .link {
      text-align: center;
      margin-top: 15px;
    }

    .link a {
      color: #ffd700;
      text-decoration: none;
      font-weight: bold;
    }

    .link a:hover {
      text-decoration: underline;
      color: #ffffff;
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(20px); }
      to { opacity: 1; transform: translateY(0); }
    }
  </style>
</head>
<body>
    <div class="container">
        <h2>Signup</h2>
        <form action="signup_process.php" method="POST">
            <input type="text" name="username" placeholder="Username" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Sign Up</button>
        </form>
        <div class="link">
            <a href="index.php">Already have an account? Login</a>
        </div>
    </div>
</body>
</html>
