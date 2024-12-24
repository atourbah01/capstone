<?php
session_start();
global $pdo;
if(isset($_POST['change-pass'])) {
    // Check if the password field is not empty
    if(!empty($_POST['Pass'])) {
        // Sanitize and validate the new password (you may add more validation)
        $newPassword = $_POST['Pass']; // You may need to hash the password before storing it in the database

        // Connect to the database (replace with your actual connection details)
        require_once 'dbconf.php';

        // Retrieve the user ID from the session (assuming it's stored there)
        $userId = isset($_SESSION['userid']) ? $_SESSION['userid'] : '';

        // Update the password in the database
        $query = "UPDATE users SET password = :password WHERE userid = :userid";
        $stmt = $pdo->prepare($query);
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        $stmt->bindParam(':password', $newPassword);
        $stmt->bindParam(':userid', $userId);

        if($stmt->execute()) {
            // Password updated successfully, redirect the user to index.php
            header("Location: index.php");
            exit;
        } else {
            // Error occurred while updating the password
            echo "Error: Failed to update the password.";
        }
    } else {
        // Password field is empty
        echo "Error: Password field cannot be empty.";
    }
}
?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="fonts/icomoon/style.css">
    <link rel="stylesheet" href="css/owl.carousel.min.css">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">

    <!-- Style -->
    <link rel="stylesheet" href="css/style.css">

    <title>Login</title>
    <!-- Dark Mode CSS (Sample, customize as needed) -->
    <style id="dark-mode-style">
    body.theme-dark {
    background-color: #121212;
        color: #ffffff;
      }

      .navbar.theme-dark {
    background-color: #333333;
      }

    </style>
  </head>
  <body>

  <div class="content">
    <div class="container">
      <div class="row">
        <div class="col-md-6 order-md-2">
          <img src="images/colorchat.jpeg" alt="Image" class="img-fluid">
        </div>
        <div class="col-md-6 contents">
          <div class="row justify-content-center">
            <div class="col-md-8">
              <div class="mb-4">
              <h3>Modify Password In to <strong>Color Chat</strong></h3>
              <p class="mb-4"> Color your conversations, color your life!</p>
            </div>
            <form action="#" method="post">
                <div class="form-group last mb-4">
                    <label for="Pass">Password</label>
                    <input type="password" class="form-control" id="Pass" name="Pass">

                </div>

              <input type="submit" value="Change Password" class="btn text-white btn-block btn-primary" id="change-pass" name="change-pass">
            </form>
          </div>

        </div>

      </div>
    </div>
  </div>


    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/main.js"></script>
    <!-- Include jQuery -->
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>

  <!-- Font Awesome Icons -->
  <script src="https://kit.fontawesome.com/3a03770c9c.js" crossorigin="anonymous"></script>
  </div>
  </body>
</html>