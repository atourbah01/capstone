<?php
session_start();
require_once 'dbconf.php'; // Include your database configuration file

$userid = isset($_POST['userid']) ? $_POST['userid'] : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';

// Validate input (you might want to add more validation rules)
if (empty($userid) || empty($password)) {
    echo json_encode(array("error" => "Please provide both user ID and password."));
    exit;
}

// Connect to the database (replace with your actual connection details)
try {
    $pdo = new PDO("mysql:host=127.0.0.1;port=3306;dbname=capstone;charset=utf8mb4", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo json_encode(array("error" => "Database connection error: " . $e->getMessage()));
    exit;
}

// Prepare and execute the query to retrieve user credentials
$query = "SELECT * FROM users WHERE userid = :userid";
$stmt = $pdo->prepare($query);
$stmt->bindParam(":userid", $userid);
$stmt->execute();

// Fetch the user record
$userRecord = $stmt->fetch(PDO::FETCH_ASSOC);

if ($userRecord) {
    // User found, compare the hashed password
    $hashedPasswordInDatabase = $userRecord['password'];

    // Use password_verify to check if the entered password matches the stored hash
    if (password_verify($password, $hashedPasswordInDatabase)) {
        $_SESSION['userid']=$userid;
        echo json_encode(array("success" => true));}
    } else {
    echo json_encode(array("error" => "User not found. Please Signup"));
}
?>
