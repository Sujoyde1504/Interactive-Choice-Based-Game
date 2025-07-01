<?php
// session + DB setup
session_start();
$conn = new mysqli('localhost', 'root', '', 'interactive');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$page_name = "scene3.1.php";
$username = $_SESSION['username'];
$_SESSION['page_name'] = $page_name;

// Save page name to DB
$sql = "UPDATE users SET page_name = ? WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $page_name, $username);
$stmt->execute();
$stmt->close();
$conn->close();

// Generate and store 5-digit code
$princeCode = rand(10000, 99999);
$_SESSION['prince_code'] = $princeCode;


include 'unlock_character.php';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dialogue System</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Cinzel:wght@700&family=Lora:wght@400&display=swap');

        body {
            font-family: 'Lora', serif;
            background-image: url('https://c4.wallpaperflare.com/wallpaper/336/141/183/forest-landscape-toon-colors-field-road-wallpaper-preview.jpg');
            background-size: cover;
            background-position: center;
            margin: 0;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .dialogue-container {
            position: fixed;
            bottom: 5%;
            left: 50%;
            transform: translateX(-50%);
            background-color: rgba(255, 255, 255, 0.9);
            border: 2px solid gold;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
            padding: 20px;
            width: 80%;
            max-width: 600px;
            text-align: left;
            display: flex;
            align-items: flex-start;
            height: 20%;
        }

        .character-image {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            margin-right: 15px;
            border: 2px solid gold;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.5);
        }

        .dialogue-text {
            font-size: 23px;
            min-height: 50px;
            flex: 1;
        }

        /* POPUP STYLES */
        #popup {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(20, 0, 50, 0.8);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 999;
            font-family: 'Cinzel', serif;
        }

        .popup-box {
            background: #fef6e4;
            border: 5px solid gold;
            border-radius: 20px;
            padding: 30px;
            text-align: center;
            box-shadow: 0 0 30px gold;
            color: #3e2723;
            max-width: 400px;
        }

        .popup-box h2 {
            margin-bottom: 10px;
            color: #b8860b;
            font-size: 28px;
        }

        .code-display {
            font-size: 32px;
            font-weight: bold;
            margin: 20px 0;
            color: crimson;
            letter-spacing: 5px;
        }

        .popup-box button {
            padding: 10px 20px;
            font-size: 16px;
            background: crimson;
            color: white;
            border: none;
            border-radius: 10px;
            cursor: pointer;
        }

        .popup-box button:hover {
            background-color: darkred;
        }
    </style>
</head>
<body>
    <div class="dialogue-container" id="dialogue-container">
        <img id="character-image" class="character-image" src="" alt="Character">
        <div>
            <div id="dialogue-text" class="dialogue-text"></div>
        </div>
    </div>

    <!-- PRINCE POPUP -->
    <div id="popup">
        <div class="popup-box">
            <h2>👑 Prince's Mark</h2>
            <p>Remember this sacred code:</p>
            <div id="code" class="code-display"></div>
            <button onclick="closePopup()">Got it</button>
        </div>
    </div>

    <script>
        let flag = 0;
        const dialogues = [
            { text: "I am Orin, Keeper of the Lost Glyphs. I walk time’s thread to guide those who dare to change fate.", speakerImage: "wizardOrin.png" },
            { text: "This scroll bears a code—one you cannot read now, but in the darkest hour, it shall unlock what brute strength cannot.", speakerImage: "wizardOrin.png" },
            { text: "He vanishes in a shimmer of wind and dust, leaving silence—and destiny—in his wake.", speakerImage: "" }
        ];

        let currentDialogueIndex = 0;
        let isTyping = false;

        window.onload = function () {
            document.getElementById('dialogue-container').style.display = 'flex';
            displayDialogue();
        };

        function displayDialogue() {
            const dialogue = dialogues[currentDialogueIndex];
            if (!dialogue) return;

            const characterImage = document.getElementById('character-image');
            if (dialogue.speakerImage) {
                characterImage.style.display = 'block';
                characterImage.src = dialogue.speakerImage;
            } else {
                characterImage.style.display = 'none';
            }

            typeText(dialogue.text);
        }

        function typeText(text, callback) {
            const dialogueText = document.getElementById('dialogue-text');
            dialogueText.innerHTML = '';
            isTyping = true;

            let index = 0;
            const typingInterval = setInterval(() => {
                if (index < text.length) {
                    dialogueText.innerHTML += text.charAt(index);
                    index++;
                } else {
                    clearInterval(typingInterval);
                    isTyping = false;
                    if (callback) callback();
                }
            }, 5);
        }

        document.getElementById('dialogue-container').addEventListener('click', nextDialogue);

        function nextDialogue() {
            if (isTyping) return;

            currentDialogueIndex++;
            if (currentDialogueIndex < dialogues.length) {
                displayDialogue();
            } else {
                const code = <?php echo json_encode($_SESSION['prince_code']); ?>;
                document.getElementById('code').innerText = code;
                document.getElementById('popup').style.display = 'flex';
            }
        }

        function closePopup() {
            document.getElementById('popup').style.display = 'none';
            window.location.href = "rulesTreeRiddle.php"; // Or whatever next page
        }
    </script>
</body>
</html>
