<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isset($_SESSION['signup_data'])) {
        die(json_encode(['success' => false, 'message' => 'OTP session expired']));
    }
    
    $userOTP = $_POST['otp'];
    $storedOTP = $_SESSION['signup_data']['otp'];
    $otpExpiry = $_SESSION['signup_data']['otp_expiry'];
    
    // Check if OTP is expired
    if (strtotime($otpExpiry) < time()) {
        unset($_SESSION['signup_data']);
        die(json_encode(['success' => false, 'message' => 'OTP expired']));
    }
    
    // Verify OTP
    if ($userOTP != $storedOTP) {
        die(json_encode(['success' => false, 'message' => 'Invalid OTP']));
    }
    
    // OTP verified - create user account
    $conn = new mysqli('localhost', 'root', '', 'interactive');
    
    if ($conn->connect_error) {
        die(json_encode(['success' => false, 'message' => 'Database connection failed']));
    }
    
    $username = $_SESSION['signup_data']['username'];
    $email = $_SESSION['signup_data']['email'];
    $password = $_SESSION['signup_data']['password'];
    
    $sql = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $username, $email, $password);
    
    if ($stmt->execute()) {
        unset($_SESSION['signup_data']);
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to create account']);
    }
    
    $stmt->close();
    $conn->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
}
?>