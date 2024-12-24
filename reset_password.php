<?php
session_start();
global $pdo;
require_once 'dbconf.php'; // Include your database configuration file
require_once 'PHPMailer/PHPMailer.php';
require_once 'PHPMailer/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the user's email from the POST data
    $userEmail = $_POST["email"];
    // Perform server-side validation on the email address if needed

    // Check if the user email exists in the database
    $query = "SELECT * FROM users WHERE email = :email";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":email", $userEmail);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        // Generate a unique OTP code
        $otpCode = generateOTP();

        // Store the OTP code in the session
        $_SESSION['otp'][$userEmail] = $otpCode;

        // Send the OTP code via email
        $subject = "Password Reset OTP";
        $message = "Your OTP code for password reset is: $otpCode";

        try {
            sendEmail($userEmail, $subject, $message);
            echo json_encode(array("status" => "success"));
        } catch (Exception $e) {
            echo json_encode(array("status" => "error", "message" => "Failed to send the OTP code."));
        }
    } else {
        // User with the provided email does not exist
        echo json_encode(array("status" => "error", "message" => "User not found."));
    }
} else {
    // Handle the case where the script is accessed directly without a POST request
    echo json_encode(array("status" => "error", "message" => "Invalid request method."));
}

function generateOTP() {
    // Generate a random OTP code (6 digits)
    return mt_rand(100000, 999999);
}

function sendEmail($recipient, $subject, $message) {
    // Create a PHPMailer instance
    $mail = new PHPMailer(true);

    // SMTP configuration
    $mail->isSMTP();
    $mail->Host = 'pod51013.outlook.com';//'live.smtp.mailtrap.io'; // SMTP server address
    $mail->SMTPAuth = true;
    $mail->Username = 'abdallah.tourbah@lau.edu';//'api'; // SMTP username
    $mail->Password = 'Wonderland123+';//'bd8b714ec9336eee8d9cf095a03d221e'; // SMTP password
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;

    // Sender and recipient settings
    $mail->setFrom('abdallah.tourbah@lau.edu', 'ColorChat');
    $mail->addAddress($recipient);

    // Email content
    $mail->isHTML(true);
    $mail->Subject = $subject;
    $mail->Body = $message;

    // Send the email
    $mail->send();
}
?>

