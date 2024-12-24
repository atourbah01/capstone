<?php
global $pdo;
session_start();
require_once 'dbconf.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if all required form fields are set
    if (!isset($_POST["firstname"]) || !isset($_POST["lastname"]) || !isset($_POST["email"]) || !isset($_POST["userid"]) || !isset($_POST["password"]) || !isset($_POST["cpassword"])) {
        echo json_encode(array("error" => "One or more required fields are missing."));
        exit;
    }

    // Get user input
    $firstname = $_POST["firstname"];
    $lastname = $_POST["lastname"];
    $email = $_POST["email"];
    $userid = $_POST["userid"];
    $password = $_POST["password"];
    $cpassword = $_POST["cpassword"];

    // Check if password matches confirm password
    if ($password != $cpassword) {
        echo json_encode(array("error" => "Password and confirm password do not match."));
        exit;
    }

    // Check if the user ID is unique
    // Assuming you have a users table in your database
    $query = "SELECT * FROM users WHERE userid = :userid";
    // Use prepared statements to prevent SQL injection
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":userid", $userid);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        // User ID already exists
        echo json_encode(array("error" => "User ID is already chosen by someone else. Please choose a different User ID."));
    } else {
        // User ID is unique, proceed with registration
        // Hash the password before saving to the database for security
        if (!empty($password)) {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        } else {
            echo json_encode(array("error" => "Password cannot be empty."));
            exit;
        }

        // Insert user information into the database
        $insertQuery = "INSERT INTO users (firstname, lastname, email, userid, password, cpassword) VALUES (:firstname, :lastname, :email, :userid, :password, :cpassword)";
        $insertStmt = $pdo->prepare($insertQuery);
        $insertStmt->bindParam(":firstname", $firstname);
        $insertStmt->bindParam(":lastname", $lastname);
        $insertStmt->bindParam(":email", $email);
        $insertStmt->bindParam(":userid", $userid);
        $insertStmt->bindParam(":password", $hashedPassword);
        $insertStmt->bindParam(":cpassword", $hashedPassword);

        if ($insertStmt->execute()) {
            // Registration successful
            echo json_encode(array("success" => true));
        } else {
            // Registration failed
            echo json_encode(array("error" => "Failed to register user."));
        }
    }
} else {
    // Handle the case where the script is accessed directly without a POST request
    echo json_encode(array("error" => "Invalid request method."));
}
?>
