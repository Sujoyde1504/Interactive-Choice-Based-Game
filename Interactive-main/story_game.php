<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "interactive";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create Story
if (isset($_POST['create_story'])) {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $creator_id = 1; // Assuming a fixed creator_id for this example (could be dynamic if user authentication is added)

    // Insert the story into the database
    $stmt = $conn->prepare("INSERT INTO stories (title, description, creator_id) VALUES (?, ?, ?)");
    $stmt->bind_param("ssi", $title, $description, $creator_id);
    $stmt->execute();
    $story_id = $stmt->insert_id;
    $stmt->close();

    // Create starting part (first dialogue)
    $stmt = $conn->prepare("INSERT INTO parts (story_id, dialogue) VALUES (?, ?)");
    $stmt->bind_param("is", $story_id, "Welcome to the beginning of your story. What will happen next?");
    $stmt->execute();
    $starting_part_id = $stmt->insert_id;
    $stmt->close();

    // Update the story with the starting part ID
    $stmt = $conn->prepare("UPDATE stories SET starting_part_id = ? WHERE id = ?");
    $stmt->bind_param("ii", $starting_part_id, $story_id);
    $stmt->execute();
    $stmt->close();

    // Redirect to the same page to show the generated link
    header("Location: ?story_id=$story_id&part_id=$starting_part_id");
    exit();
}

// Add Choices
if (isset($_POST['add_choice']) && isset($_GET['story_id']) && isset($_GET['part_id'])) {
    $story_id = $_GET['story_id'];
    $part_id = $_GET['part_id'];
    $choice_text = $_POST['choice_text'];
    $next_part_content = $_POST['next_part_content'];

    // Insert the choice into the database
    $stmt = $conn->prepare("INSERT INTO choices (story_id, choice_text, next_part_id) VALUES (?, ?, ?)");
    $stmt->bind_param("isi", $story_id, $choice_text, $next_part_id);
    $stmt->execute();
    $stmt->close();

    // Create next part (dialogue)
    $stmt = $conn->prepare("INSERT INTO parts (story_id, content) VALUES (?, ?)");
    $stmt->bind_param("is", $story_id, $next_part_content);
    $stmt->execute();
    $next_part_id = $stmt->insert_id;
    $stmt->close();

    // Update the choice with the next part ID
    $stmt = $conn->prepare("UPDATE choices SET next_part_id = ? WHERE id = ?");
    $stmt->bind_param("ii", $next_part_id, $choice_id);
    $stmt->execute();
    $stmt->close();
}

// Fetch Story, Part, and Choices for Playing
if (isset($_GET['story_id']) && isset($_GET['part_id'])) {
    $story_id = $_GET['story_id'];
    $part_id = $_GET['part_id'];

    $story_result = $conn->query("SELECT * FROM stories WHERE id = $story_id");
    $story = $story_result->fetch_assoc();
    
    $part_result = $conn->query("SELECT * FROM parts WHERE id = $part_id");
    $part = $part_result->fetch_assoc();
    
    $choices_result = $conn->query("SELECT * FROM choices WHERE story_id = $story_id AND part_id = $part_id");
    $choices = $choices_result->fetch_all(MYSQLI_ASSOC);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create and Play Story</title>
</head>
<body>

<?php if (!isset($_GET['story_id'])): ?>
    <h1>Create Your Story</h1>
    <form method="POST" action="">
        <label for="title">Story Title:</label>
        <input type="text" name="title" required><br><br>

        <label for="description">Story Description:</label>
        <textarea name="description" required></textarea><br><br>

        <button type="submit" name="create_story">Create Story</button>
    </form>
<?php endif; ?>

<?php if (isset($_GET['story_id']) && isset($_GET['part_id']) && isset($part)): ?>
    <h1><?= $story['title'] ?></h1>
    <p><?= $part['content'] ?></p>

    <!-- Add choices -->
    <h3>Add Choices</h3>
    <form method="POST" action="">
        <input type="hidden" name="story_id" value="<?= $_GET['story_id'] ?>">
        <input type="hidden" name="part_id" value="<?= $_GET['part_id'] ?>">

        <label for="choice_text">Choice Text:</label>
        <input type="text" name="choice_text" required><br><br>

        <label for="next_part_content">Next Part (Dialogue):</label>
        <textarea name="next_part_content" required></textarea><br><br>

        <button type="submit" name="add_choice">Add Choice</button>
    </form>

    <h3>Choices:</h3>
    <?php if (count($choices) > 0): ?>
        <ul>
            <?php foreach ($choices as $choice): ?>
                <li><a href="?story_id=<?= $story_id ?>&part_id=<?= $choice['next_part_id'] ?>"><?= $choice['choice_text'] ?></a></li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>No choices added yet. Go ahead and add some choices!</p>
    <?php endif; ?>
<?php endif; ?>

</body>
</html>
