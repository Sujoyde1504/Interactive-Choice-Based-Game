<?php
session_start(); // Start the session at the top of the file
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adventure Prince Navigation</title>
    <style>
        body {
            font-family: 'Georgia', serif; /* Use a serif font for a classic feel */
            margin: 0;
            background-size: cover;
            color: #fff; /* White text for contrast */
            text-align: center;
        }
        nav {
            background-color: rgba(54, 27, 101, 0.8); /* Dark royal color with transparency */
            padding: 10px 0;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.5);
        }
        nav a {
            display: inline-block;
            color: #f0e68c; /* Gold color for links */
            text-align: center;
            padding: 14px 20px;
            text-decoration: none;
            border-radius: 5px; /* Rounded corners for links */
            margin: 0 5px;
            transition: background-color 0.3s, transform 0.3s;
        }
        nav a:hover {
            background-color: rgba(255, 215, 0, 0.7); /* Lighter gold on hover */
            color: black;
            transform: scale(1.1); /* Slightly enlarge link on hover */
        }
        #content {
            width: 100%;
            height: calc(100vh - 60px); /* Adjust the height of the iframe */
            border: none;
            border-top: 5px solid rgba(255, 215, 0, 0.7); /* Gold border on top */
            box-shadow: inset 0 0 10px rgba(0, 0, 0, 0.7); /* Shadow effect */
        }
        .username {
            position: absolute;
            right: 20px; /* Align to the right */
            top: 14px; /* Adjust to match the navbar's height */
            color: #f0e68c;
            font-size: 16px;
            background-color: rgba(54, 27, 101, 0.8); /* Dark royal color with transparency */
            padding: 5px 10px; /* Padding to make the background color around the text */
            border-radius: 5px; /* Rounded corners for the background */
        }
    </style>
</head>
<body>
    <nav>
        <a href="#" onclick="loadContent('overview.html')">Overview</a>
        <a href="#" onclick="loadContent('<?php echo $_SESSION['page_name'] ?? 'scene1.php'; ?>')">Play</a>
        <a href="#" onclick="loadContent('home.html')">Home</a>
        <a href="#" onclick="loadContent('community.php')">Community</a>
        <a href="#" onclick="loadContent('characters.php')">Characters</a>
        <a href="#" onclick="loadContent('about us.html')">About Us</a>
        <?php if (isset($_SESSION['username'])): ?>
            <div class="username"><?php echo htmlspecialchars($_SESSION['username']); ?></div>
        <?php endif; ?>
    </nav>
    <iframe id="content" src="home.html"></iframe>

    <script>
        function loadContent(page) {
            const iframe = document.getElementById('content');
            iframe.src = page;
        }
        window.addEventListener('message', function(event) {
            if (event.data.type === 'start') {
                if (event.data.value === 1) {
                    loadContent('scene1.php');
                    window.parent.postMessage({ type: 'start', value: 0 }, '*');
                }
                if (event.data.value === 2) {
                    loadContent('<?php echo $_SESSION['page_name'] ?? 'scene1.php'; ?>');
                    window.parent.postMessage({ type: 'start', value: 0 }, '*');
                }
            }
        });
    </script>
</body>
</html>
