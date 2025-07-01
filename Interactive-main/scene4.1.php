<?php
// Database connection
session_start();
$conn = new mysqli('localhost', 'root', '', 'interactive');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Define the page name in the PHP variable
$page_name = "scene4.1.php";  // This can be any dynamic or static name
$username = $_SESSION['username'];
$_SESSION['page_name'] = $page_name;
// Insert the page name into the database
$sql = "UPDATE users SET page_name = ? WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $page_name, $username);

if ($stmt->execute()) {
    $message = "Page name stored successfully!";
} else {
    $message = "Error: " . $stmt->error;
}


include 'unlock_character.php';

$stmt->close();
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dialogue System</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Cinzel:wght@700&family=Lora:wght@400&display=swap');

        body {
            font-family: 'Lora', serif;
            background-image: url('https://wallpapers.com/images/hd/kingdom-1920-x-1200-wallpaper-qsds2pnnzbvtuh5w.jpg');
            background-size: cover;
            background-position: center;
            margin: 0;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        @keyframes fadeInCollapse {
            0% {
                opacity: 0;
                transform: translateY(-50px);
            }
            20% {
                opacity: 1;
                transform: translateY(0);
            }
            80% {
                opacity: 1;
                transform: translateY(0);
            }
            100% {
                opacity: 0;
                transform: scaleY(0);
                transform-origin: top;
            }
        }

        .dialogue-container {
            display: none;
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

        .choices {
            display: none;
            margin-top: 15px;
        }

        .choices button {
            margin: 5px;
            padding: 10px 15px;
            font-size: 16px;
            background-color: #CB80AB;
            color: white;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            font-family: 'Cinzel', serif;
            transition: background-color 0.3s, transform 0.2s;
        }

        .choices button:hover {
            background-color: gold;
            transform: scale(1.05);
        }
    </style>
</head>
<body>
    <div class="overlay-text" id="overlay-text"></div>

    <div class="dialogue-container" id="dialogue-container">
        <img id="character-image" class="character-image" src="" alt="Character">
        <div>
            <div id="dialogue-text" class="dialogue-text"></div>
            <div id="choices" class="choices"></div>
        </div>
    </div>

    <script>
        var flag = 0;
        const dialogues = [
            { text: "Throne Hall of Nuvoria – Majestic but eerily silent", speakerImage: "" },
            { text: "Valen… the traitor’s son walks into my court as if welcome", speakerImage: "Queen.png" },
            { text: "I'm not here for your forgiveness, Gladrial—just for help.", speakerImage: "character1.png" },
            { text: "Then find it… if you can.", speakerImage: "Queen.png" },
            { text: "She raises her hand—magic flares—and the marble floor cracks open beneath them.", speakerImage: "", flag: 1 }
        ];

        let currentDialogueIndex = 0;
        let isTyping = false;

        window.onload = function() {
            document.getElementById('dialogue-container').style.display = 'flex';
            displayDialogue();
        };

        function displayDialogue() {
            const dialogue = dialogues[currentDialogueIndex];
            if (!dialogue) return;

            // Show or hide character image based on the presence of speakerImage
            const characterImage = document.getElementById('character-image');
            if (dialogue.speakerImage) {
                characterImage.style.display = 'block';
                characterImage.src = dialogue.speakerImage;
            } else {
                characterImage.style.display = 'none';
            }

            typeText(dialogue.text);

            if (dialogue.flag === 1) {
                flag = 1;
            }
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
            } else if (flag === 1) {
                window.location.href = "maze.php";
            }
        }
    </script>
</body>
</html>
