<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $conn = new mysqli('localhost', 'root', '', 'interactive');

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Modify SQL query to fetch the 'page_name' along with the password
    $sql = "SELECT password, page_name FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($hashed_password, $page_name);
        $stmt->fetch();

        if (password_verify($password, $hashed_password)) {
            // Start a session to store the user's data
            session_start();
            $_SESSION['username'] = $username;
            $_SESSION['page_name'] = $page_name; // Store page_name in session

            // Redirect to the success page
            header("Location: dashboard.php");
            exit();
        } else {
            echo "Invalid password.";
        }
    } else {
        echo "No account found with that username.";
    }

    $stmt->close();
    $conn->close();
}
?>
