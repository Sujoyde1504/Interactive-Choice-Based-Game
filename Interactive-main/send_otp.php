<?php
session_start();

// Manual PHPMailer includes
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';
require 'PHPMailer/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Database connection
    $conn = new mysqli('localhost', 'root', '', 'interactive');
    
    if ($conn->connect_error) {
        die(json_encode(['success' => false, 'message' => 'Database connection failed']));
    }
    
    // Get form data
    $username = $conn->real_escape_string($_POST['username']);
    $email = $conn->real_escape_string($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    
    // Check if email already exists
    $checkEmail = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $checkEmail->bind_param("s", $email);
    $checkEmail->execute();
    $checkEmail->store_result();
    
    if ($checkEmail->num_rows > 0) {
        die(json_encode(['success' => false, 'message' => 'Email already registered']));
    }
    
    // Generate OTP
    $otp = rand(100000, 999999);
    $otp_expiry = date('Y-m-d H:i:s', strtotime('+10 minutes'));
    
    // Store data in session for verification
    $_SESSION['signup_data'] = [
        'username' => $username,
        'email' => $email,
        'password' => $password,
        'otp' => $otp,
        'otp_expiry' => $otp_expiry
    ];
    
    // Send OTP via email
    $mail = new PHPMailer(true);
    
    try {
        // Enable verbose debug output
        $mail->SMTPDebug = SMTP::DEBUG_SERVER;
        
        // Server settings
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'vikashmahto981@gmail.com';
        $mail->Password   = '56771388'; // NEVER use your actual password!
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;
        
        // Recipients
        $mail->setFrom('vikashmahto981@gmail.com', 'Your App Name');
        $mail->addAddress($email, $username);
        
        // Content
        $mail->isHTML(true);
        $mail->Subject = 'Your OTP for Signup';
        $mail->Body    = "Your OTP is: <b>$otp</b><br>Valid for 10 minutes.";
        $mail->AltBody = "Your OTP is: $otp\nValid for 10 minutes.";
        
        $mail->send();
        echo json_encode(['success' => true]);
    } catch (Exception $e) {
        error_log("Mailer Error: " . $mail->ErrorInfo); // Log the error
        echo json_encode([
            'success' => false, 
            'message' => 'Failed to send OTP',
            'error' => $mail->ErrorInfo
        ]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
}
?>