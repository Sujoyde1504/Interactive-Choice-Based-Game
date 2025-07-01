<?php
include 'db.php';

// Get the story ID from the URL (or use a default value)
if (isset($_GET['story_id'])) {
    $story_id = $_GET['story_id'];
} else {
    echo "Story ID is required!";
    exit;
}

// Fetch the story node text
$stmt = $pdo->prepare("SELECT * FROM user_stories WHERE id = :id");
$stmt->execute(['id' => $story_id]);
$story = $stmt->fetch(PDO::FETCH_ASSOC);

// Fetch the options for the story node
$stmt = $pdo->prepare("SELECT * FROM story_options WHERE story_id = :story_id");
$stmt->execute(['story_id' => $story_id]);
$options = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($story['story_title']); ?></title>
</head>
<body>
    <h1><?php echo htmlspecialchars($story['story_title']); ?></h1>
    <p><?php echo nl2br(htmlspecialchars($story['story_text'])); ?></p>

    <h2>Options</h2>
    <ul>
        <?php foreach ($options as $option): ?>
            <li>
                <a href="view_story.php?story_id=<?php echo $option['next_story_id']; ?>"><?php echo htmlspecialchars($option['option_text']); ?></a>
            </li>
        <?php endforeach; ?>
    </ul>
</body>
</html>
