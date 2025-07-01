<?php
session_start();

$conn = new mysqli('localhost', 'root', '', 'interactive');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$page_name = "scene1.php";
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
            background-image: url('grasslands.jpeg');
            background-size: cover;
            background-position: center;
            margin: 0;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .overlay-text {
            font-family: 'Cinzel', serif;
            font-size: 96px;
            color: gold;
            text-align: center;
            background-color: rgba(0, 0, 0, 0.6);
            padding: 20px 40px;
            border: 3px solid gold;
            border-radius: 20px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.6);
            opacity: 0;
            animation: fadeInCollapse 4s forwards;
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
    <div class="overlay-text" id="overlay-text">Journey Begins Now</div>

    <div class="dialogue-container" id="dialogue-container">
        <img id="character-image" class="character-image" src="" alt="Character">
        <div>
            <div id="dialogue-text" class="dialogue-text"></div>
            <div id="choices" class="choices"></div>
        </div>
    </div>

    <script>
        const dialogues = [
            { text: "This is it, Roderic. Beyond those mountains, there’s no turning back.", speakerImage: "character1.png" },
            { text: "We’ve faced many trials, but this one… it’s different.", speakerImage: "character1.png" },
            { text: "You’ve always been strong, but even the bravest have doubts. If you need to stop here, I’ll understand. This path will change us both.", speakerImage: "character1.png" },
            { text: "Before we go, I have to ask—are you ready?", speakerImage: "character1.png" },
            {
                choices: [
                    {
                        text: "I am. No matter the cost, I’ll finish what we started.",
                        response: {
                            text: "I knew I could count on you. Together, we'll face whatever comes. No turning back now.",
                            followUp: "Roderic's firm commitment strengthens his bond with Valen, but it puts heavy responsibility on him. He'll face tougher challenges and may push himself to the limit, with Valen relying on him more.",
                            speakerImage: "character1.png"
                        }
                    },
                    {
                        text: "I’m not sure, but I can’t turn back now.",
                        response: {
                            text: "It’s okay to have doubts. What matters is that you're still here. We’ll figure this out—together.",
                            followUp: "Roderic’s doubt shows vulnerability, leading to internal struggles but room for growth. Valen may offer more support, and while Roderic could be more cautious, his hesitation might cause missed chances or added danger.",
                            speakerImage: "character1.png"
                        }
                    }
                ],
                speakerImage: "character2.png"
            },
            { text: "Rodrick, are you sure about this? I mean... the stories I’ve heard about Adam, the sorcerer—they’re enough to turn even the bravest warrior’s blood to ice.", speakerImage: "character1.png" },
            { text: "He's no ordinary sorcerer, that’s for certain. They say he wields powers born from the shadows themselves.", speakerImage: "character1.png" },
            { text: "People speak of him bending flames without a single touch, whispering storms into being... and that's just the beginning.", speakerImage: "character1.png"},
            { text: "And then, there’s his magic—it's... different. Darker. Adam’s spells don’t just harm; they seem to twist and corrupt, draining life around him.", speakerImage: "character1.png" },
            { text: "It’s as if he can command the very essence of life and death. The princess, wherever he’s holding her, is in unimaginable danger. If we’re going to face him, we’ll need to be prepared for magic far beyond anything we’ve ever seen.", speakerImage: "character1.png" },
            { text: "But... if anyone deserves a fighting chance against him, it’s us.", speakerImage: "character1.png" },
            { text: "As Valen and Rodrick journeyed onward, their path wound through dense, shadowed woods and treacherous foothills.", speakerImage: "" },
            { text: "The day slipped toward dusk, casting an eerie stillness over the land, when at last they came upon a fork in the road. Before them lay two paths: one veering into a dark, twisted forest rumored to hold the Goblin's Cave, a place crawling with creatures of shadow and malice.", speakerImage: "" },
            { text: "choose your path:", speakerImage: "" },
            {
                choices: [
                    {
                        text: "Enter the Goblin's Cave",
                        response: {
                            text: "Rodrick and Valen step into the darkness of the Goblin's Cave, their senses on high alert. The air grows cold, and faint whispers seem to echo off the jagged stone walls.",
                            followUp: "Inside, they must navigate traps and confront creatures that dwell in the shadows. The journey tests their strength, but there’s a glimmer of hope—they might find a relic to weaken Adam’s magic.",
                            speakerImage: "character2.png"
                        }
                    },
                    {
                        text: "Follow the path to the Isara River",
                        response: {
                            text: "Rodrick and Valen turn towards the Isara River, a winding path that leads them away from the dense shadows of the forest. The sound of flowing water brings a sense of calm, but the danger is far from over.",
                            followUp: "While the river’s path offers fewer immediate threats, it takes them closer to Adam’s watchful eyes. They’ll need to be swift and strategic, relying on stealth and speed as they make their approach.",
                            speakerImage: "character2.png"
                        }
                    }
                ],
                speakerImage: "character2.png"
            }
        ];

        let currentDialogueIndex = 0;
        let isTyping = false;
        let showingFollowUp = false;
        let displayFollowUp = null;

        window.onload = function() {
            const overlayText = document.getElementById('overlay-text');
            overlayText.addEventListener('animationend', () => {
                overlayText.style.display = 'none';
            });
            document.getElementById('dialogue-container').style.display = 'flex';
            displayDialogue();
        };

        document.getElementById('dialogue-container').addEventListener('click', nextDialogue);

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

            if (dialogue.choices) {
                document.getElementById('dialogue-text').innerHTML = '';
                showChoices(dialogue.choices);
            } else {
                typeText(dialogue.text);
            }
        }

        function showChoices(choices) {
            const choicesContainer = document.getElementById('choices');
            choicesContainer.innerHTML = '';
            choicesContainer.style.display = 'block';

            choices.forEach((choice) => {
                const button = document.createElement('button');
                button.innerText = choice.text;
                button.onclick = () => makeChoice(choice);
                choicesContainer.appendChild(button);
            });
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

        function nextDialogue() {
            if (isTyping) return;

            if (showingFollowUp && typeof displayFollowUp === "function") {
                displayFollowUp();
                displayFollowUp = null;
                return;
            }

            const current = dialogues[currentDialogueIndex];
            if (current && current.choices) return;

            currentDialogueIndex++;
            displayDialogue();
        }

        function makeChoice(choice) {
            document.getElementById('choices').style.display = 'none';

            const responseText = choice.response.text;
            const followUpText = choice.response.followUp;

            const characterImage = document.getElementById('character-image');
            characterImage.src = choice.response.speakerImage;
            characterImage.style.display = 'block';

            // Typing response
            typeText(responseText, () => {
                showingFollowUp = true;

                // Define displayFollowUp globally so nextDialogue() can access it
                displayFollowUp = function () {
                    showingFollowUp = false;
                    displayFollowUp = null;

                    characterImage.style.display = 'none';

                    typeText(followUpText, () => {
                        // Redirect based on the choice text
                        if (choice.text === "Enter the Goblin's Cave") {
                            window.location.href = "scene2.1.php";
                        } else if (choice.text === "Follow the path to the Isara River") {
                            window.location.href = "scene2.2.php";
                        } else {
                            currentDialogueIndex++;
                            displayDialogue();
                        }
                    });
                };
            });
        }

    </script>
</body>
</html>
