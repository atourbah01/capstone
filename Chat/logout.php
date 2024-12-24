<?php
// Start the session
session_start();

// Destroy the session
session_destroy();

// Redirect to the login page
header("Location: ../login-form-08/index.php");
exit;
?>

