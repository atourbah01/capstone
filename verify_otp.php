<?php
session_start();
global $pdo;
require_once 'dbconf.php'; // Include your database configuration file

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the user's email and OTP code from the POST data
    $userEmail = $_POST["email"];
    $userCode = $_POST["code"];

    // Validate the email and OTP code (you may need additional validation)

    // Retrieve the OTP code stored in the session
    $storedCode = isset($_SESSION['otp'][$userEmail]) ? $_SESSION['otp'][$userEmail] : '';

    // Compare the user-entered OTP code with the stored OTP code
    if ($userCode === $storedCode) {
        // OTP code is correct
        echo json_encode(array("status" => "success"));
    } else {
        // OTP code is incorrect
        echo json_encode(array("status" => "error", "message" => "Code entered is not the same."));
    }
} else {
    // Handle the case where the script is accessed directly without a POST request
    echo json_encode(array("status" => "error"));
}
?>
