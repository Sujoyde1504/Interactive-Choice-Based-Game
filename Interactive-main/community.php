<?php
session_start();

// Set username in the session for demonstration purposes
if (!isset($_SESSION['username'])) {
    $_SESSION['username'] = "User" . rand(1, 100); // Replace with actual login username
}

$username = $_SESSION['username'];

// Database connection
$conn = new mysqli('localhost', 'root', '', 'interactive');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle new message submission (API)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['message'])) {
    $message = $conn->real_escape_string($_POST['message']);
    $stmt = $conn->prepare("INSERT INTO messages (username, message) VALUES (?, ?)");
    $stmt->bind_param("ss", $username, $message);
    $stmt->execute();
    $stmt->close();
    exit;
}

// Fetch messages (API)
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['fetch'])) {
    $sql = "SELECT username, message FROM messages ORDER BY id ASC";
    $result = $conn->query($sql);

    $messages = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $messages[] = $row;
        }
    }

    header('Content-Type: application/json');
    echo json_encode($messages);
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Real-Time Chat</title>
<style>
    /* Royal Colors & Fonts */
        body {
        margin: 0;
        padding: 0;
        font-family: 'Georgia', serif;
        background: linear-gradient(135deg, #2c003e, #1c1a5e, #4261a1);
        background-size: 400% 400%;
        animation: royalBG 15s ease infinite;
        color: #fff;
        display: flex;
        flex-direction: column;
        height: 100vh;
        overflow: hidden;
    }

    @keyframes royalBG {
        0% {background-position: 0% 50%;}
        50% {background-position: 100% 50%;}
        100% {background-position: 0% 50%;}
    }

    .chat-container {
        flex: 1;
        padding: 20px;
        overflow-y: auto;
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: 20px;
        margin: 20px;
        box-shadow: 0 0 30px rgba(255, 255, 255, 0.15);
        backdrop-filter: blur(12px);
        animation: fadeIn 1.2s ease-in-out;
    }

    .input-container {
        display: flex;
        padding: 15px;
        background: rgba(0, 0, 0, 0.6);
        border-top: 1px solid rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(10px);
        box-shadow: 0 -2px 12px rgba(0, 0, 0, 0.5);
    }

    textarea {
        flex: 1;
        resize: none;
        border: none;
        border-radius: 12px;
        padding: 12px 16px;
        font-size: 16px;
        font-family: 'Georgia', serif;
        background: rgba(255, 255, 255, 0.1);
        color: #fff;
        outline: none;
        transition: all 0.3s ease-in-out;
    }

    textarea:focus {
        background: rgba(255, 255, 255, 0.2);
    }

    button {
        background: linear-gradient(135deg, #9c27b0, #673ab7);
        color: white;
        border: none;
        padding: 12px 20px;
        margin-left: 12px;
        border-radius: 12px;
        font-weight: bold;
        font-size: 15px;
        cursor: pointer;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    button:hover {
        transform: scale(1.08);
        box-shadow: 0 0 20px #fff;
    }

    .message {
        padding: 12px 18px;
        margin: 10px 0;
        border-radius: 18px;
        max-width: 70%;
        word-wrap: break-word;
        animation: slideUp 0.4s ease;
        position: relative;
    }

    .self {
        background: linear-gradient(135deg,rgb(239, 21, 21),rgba(246, 223, 181, 0.89));
        color: #000;
        align-self: flex-end;
        border: 1px solid #fff2c2;
    }

    .other {
        background: linear-gradient(135deg, #283e51, #485563);
        color: #fff;
        align-self: flex-start;
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    .username {
        font-weight: bold;
        font-size: 0.85em;
        margin-bottom: 5px;
        color: #ffd700;
        text-shadow: 1px 1px 2px #000;
    }

    /* Animations
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    @keyframes slideUp {
        from { transform: translateY(20px); opacity: 0; }
        to { transform: translateY(0); opacity: 1; }
    } */

    /* Scrollbar Styling */
    .chat-container::-webkit-scrollbar {
        width: 8px;
    }

    .chat-container::-webkit-scrollbar-thumb {
        background: rgba(255, 255, 255, 0.3);
        border-radius: 10px;
    }

    .chat-container::-webkit-scrollbar-track {
        background: transparent;
    }

</style>

</head>
<body>
    <div class="chat-container" id="chat-container">
        <!-- Messages will be dynamically loaded here -->
    </div>

    <form class="input-container" id="message-form">
        <textarea name="message" id="message-input" rows="1" placeholder="Type your message..." required></textarea>
        <button type="submit">Send</button>
    </form>

    <script>
        const chatContainer = document.getElementById('chat-container');
        const messageForm = document.getElementById('message-form');
        const messageInput = document.getElementById('message-input');

        // Function to fetch and display messages
        async function fetchMessages() {
            const response = await fetch('community.php?fetch=true');
            const messages = await response.json();

            // Clear the chat container
            chatContainer.innerHTML = '';

            // Render each message
            messages.forEach((msg) => {
                const messageDiv = document.createElement('div');
                messageDiv.classList.add('message');
                messageDiv.classList.add(msg.username === "<?= $username ?>" ? 'self' : 'other');
                messageDiv.innerHTML = `
                    <div class="username">${msg.username}</div>
                    ${msg.message}
                `;
                chatContainer.appendChild(messageDiv);
            });

            // Scroll to the bottom
            chatContainer.scrollTop = chatContainer.scrollHeight;
        }

        // Fetch messages every 2 seconds
        setInterval(fetchMessages, 2000);

        // Submit a new message without refreshing
        messageForm.addEventListener('submit', async (event) => {
            event.preventDefault();

            const message = messageInput.value.trim();
            if (!message) return;

            await fetch('community.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: new URLSearchParams({ message }),
            });

            messageInput.value = ''; // Clear the input field
            fetchMessages(); // Refresh messages
        });

        // Initial fetch
        fetchMessages();
    </script>
</body>
</html>

<?php
$conn->close();
?>
