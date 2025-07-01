<?php
session_start();
$conn = new mysqli("localhost", "root", "", "interactive");
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

if (!isset($_SESSION['username'])) return;

$username = $_SESSION['username'];

$unlocked = [];
$fetch = $conn->prepare("SELECT character_image, character_name FROM unlocked_characters WHERE username = ?");
$fetch->bind_param("s", $username);
$fetch->execute();
$res = $fetch->get_result();
while ($row = $res->fetch_assoc()) {
    $unlocked[$row['character_image']] = $row['character_name'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Character Inventory</title>
  <style>
    body {
      background: #121222;
      font-family: 'Segoe UI', sans-serif;
      color: #fff;
      margin: 0;
      padding: 30px;
    }

    h1 {
      text-align: center;
      margin-bottom: 30px;
    }

    .inventory {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 20px;
      max-width: 900px;
      margin: auto;
    }

    .character {
      background: #1f1f2f;
      border-radius: 12px;
      overflow: hidden;
      text-align: center;
      box-shadow: 0 0 12px rgba(0, 255, 255, 0.15);
    }

    .char-image {
      width: 100%;
      height: 220px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 80px;
      color: #aaa;
      background: #2a2a3f;
    }

    .char-image img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      border-top-left-radius: 12px;
      border-top-right-radius: 12px;
      transition: transform 0.3s ease;
    }

    .character:hover img {
      transform: scale(1.08);
    }

    .nameplate {
      padding: 10px;
      background: #2a2a3f;
      font-size: 15px;
      font-weight: bold;
      border-top: 2px solid #00ffff;
      border-bottom-left-radius: 12px;
      border-bottom-right-radius: 12px;
      letter-spacing: 2px;
    }
  </style>
</head>
<body>

  <h1>Character Inventory</h1>

  <div class="inventory">
    <?php
    $total_slots = 20;
    $count = 0;

    foreach ($unlocked as $img => $name) {
        echo "<div class='character'>
                <div class='char-image'><img src='$img'></div>
                <div class='nameplate'>$name</div>
              </div>";
        $count++;
    }

    for (; $count < $total_slots; $count++) {
        echo "<div class='character'>
                <div class='char-image'>?</div>
                <div class='nameplate'>???</div>
              </div>";
    }
    ?>
  </div>

</body>
</html>
