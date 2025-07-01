<?php
// Database connection
session_start();
$conn = new mysqli('localhost', 'root', '', 'interactive');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$page_name = "scene3.2.php";
$username = $_SESSION['username'];
$_SESSION['page_name'] = $page_name;

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
            background-image: url('purple night.jpg');
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
            height: auto;
            flex-direction: column;
        }

        .character-image {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            margin-right: 15px;
            border: 2px solid gold;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.5);
        }

        .dialogue-row {
            display: flex;
            align-items: flex-start;
            width: 100%;
        }

        .dialogue-text {
            font-size: 23px;
            min-height: 50px;
            flex: 1;
        }

        .choices {
            display: none;
            margin-top: 15px;
            width: 100%;
            display: flex;
            justify-content: center;
            gap: 10px;
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
    <div class="dialogue-container" id="dialogue-container">
        <div class="dialogue-row">
            <img id="character-image" class="character-image" src="" alt="Character" style="display: none;">
            <div id="dialogue-text" class="dialogue-text"></div>
        </div>
        <div id="choices" class="choices"></div>
    </div>

    <script>
        const dialogues = [
            { text: "Kane is one of Dark Sorcerer Adam's most feared disciples — a silent assassin trained in shadow warfare and arcane blades. Once a royal guard who betrayed the crown, he now roams as Adam’s enforcer, striking fear with swift.", speakerImage: "" },
            { text: "You’re far from the castle, bowman—turn back, or bleed for nothing.", speakerImage: "Kane.png" },
            { text: "I don’t bleed for nothing... but I do fight for something.", speakerImage: "character1.png" },
            { text: "Then let’s see if your cause makes you faster than my steel.", speakerImage: "Kane.png" },
            { text: "Face me—not in combat, but in challenge: power, mind… or luck. Pick one. Let’s see what you’re truly made of.", speakerImage: "Kane.png" }
        ];

        let currentDialogueIndex = 0;
        let isTyping = false;

        window.onload = function () {
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
                showChoices();
            }
        }

        function showChoices() {
            const choicesDiv = document.getElementById('choices');
            choicesDiv.style.display = 'flex';

            const choices = ['Power', 'Mind', 'Luck'];
            choicesDiv.innerHTML = '';

            choices.forEach(choice => {
                const btn = document.createElement('button');
                btn.textContent = choice;
                btn.onclick = () => handleChoice(choice);
                choicesDiv.appendChild(btn);
            });
        }

        function handleChoice(choice) {
            // Redirect to respective battle page
            if (choice === "Power") {
                window.location.href = "rulesPowerJudgement.php";
            } else if (choice === "Mind") {
                window.location.href = "Game3.php";
            } else if (choice === "Luck") {
                window.location.href = "rulesThroughTheLies.php";
            }
        }
    </script>
</body>
</html>
