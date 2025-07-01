<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Insert the story text into the database
    $story_title = $_POST['story_title'];
    $story_text = $_POST['story_text'];
    $user_id = 1; // Assume a logged-in user, replace with actual user ID

    // Insert story text into the database
    $stmt = $pdo->prepare("INSERT INTO user_stories (user_id, story_title, story_text) VALUES (:user_id, :story_title, :story_text)");
    $stmt->execute(['user_id' => $user_id, 'story_title' => $story_title, 'story_text' => $story_text]);
    $story_id = $pdo->lastInsertId(); // Get the inserted story's ID

    // Insert options for the story
    if (!empty($_POST['option_text']) && !empty($_POST['next_story_id'])) {
        foreach ($_POST['option_text'] as $index => $option_text) {
            $next_story_id = $_POST['next_story_id'][$index];
            $stmt = $pdo->prepare("INSERT INTO story_options (story_id, option_text, next_story_id) VALUES (:story_id, :option_text, :next_story_id)");
            $stmt->execute(['story_id' => $story_id, 'option_text' => $option_text, 'next_story_id' => $next_story_id]);
        }
    }

    echo "Story created successfully!";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Story</title>
</head>
<body>
    <h1>Create Your Story</h1>
    <form method="POST">
        <label for="story_title">Story Title</label>
        <input type="text" id="story_title" name="story_title" required><br><br>

        <label for="story_text">Story Text</label><br>
        <textarea id="story_text" name="story_text" rows="4" cols="50" required></textarea><br><br>

        <label>Options</label><br>
        <div id="options">
            <div>
                <label for="option_text[]">Option Text</label>
                <input type="text" name="option_text[]" required>
                <label for="next_story_id[]">Next Story ID</label>
                <input type="number" name="next_story_id[]" required><br><br>
            </div>
        </div>

        <button type="button" id="addOption">Add Option</button><br><br>
        <button type="submit">Create Story</button>
    </form>

    <script>
        // Add new option input fields dynamically
        document.getElementById('addOption').addEventListener('click', function() {
            var optionDiv = document.createElement('div');
            optionDiv.innerHTML = `
                <label for="option_text[]">Option Text</label>
                <input type="text" name="option_text[]" required>
                <label for="next_story_id[]">Next Story ID</label>
                <input type="number" name="next_story_id[]" required><br><br>
            `;
            document.getElementById('options').appendChild(optionDiv);
        });
    </script>
</body>
</html>
