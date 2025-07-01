<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$conn = new mysqli("localhost", "root", "", "interactive");
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

if (!isset($_SESSION['username']) || !isset($_SESSION['page_name'])) return;

$username = $_SESSION['username'];
$page = $_SESSION['page_name'];

// Allow multiple characters per scene
$character_map = [
    'scene1.php' => [
        ['image' => 'character2.png', 'name' => 'Rodrick'],
        ['image' => 'overview2.jpeg', 'name' => 'Adam: The Sorcerer'],
        ['image' => 'character1.png', 'name' => 'Valen']
    ],
    'scene2.1.php' => [
        ['image' => 'Goblin.png', 'name' => 'Goblin King']
    ],
    'scene3.2.php' => [
        ['image' => 'Kane.png', 'name' => 'Kane']
    ],
    'scene4.1.php' => [
        ['image' => 'Queen.png', 'name' => 'Queen Gladrial']
    ],
    'scene3.1.php' => [
        ['image' => 'wizardOrin.png', 'name' => 'Orin']
    ]
];

if (isset($character_map[$page])) {
    foreach ($character_map[$page] as $char) {
        $img = $char['image'];
        $name = $char['name'];

        $check = $conn->prepare("SELECT 1 FROM unlocked_characters WHERE username = ? AND character_image = ?");
        $check->bind_param("ss", $username, $img);
        $check->execute();
        $result = $check->get_result();

        if ($result->num_rows === 0) {
            $insert = $conn->prepare("INSERT INTO unlocked_characters (username, character_image, character_name) VALUES (?, ?, ?)");
            $insert->bind_param("sss", $username, $img, $name);
            $insert->execute();
        }
    }
}
