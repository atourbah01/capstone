<?php
session_start();
if(isset($_SESSION['userid'])){
    header("location: ../Chat/main.php");
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
              <h3>Sign In to <strong>Color Chat</strong></h3>
              <p class="mb-4"> Color your conversations, color your life!</p>
            </div>
            <form action="#" method="post">
              <div class="form-group first">
                <label for="userid">User ID</label>
                <input type="text" class="form-control" id="userid" name="userid">

              </div>
                <div class="form-group last mb-4">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" id="password">

                </div>

                <div class="d-flex mb-5 align-items-center">
                    <span class="ml-auto"><a href="#" class="forgot-pass">Forgot Password?</a></span>
                </div>

              <span class="ml-auto"><a href="#" class="sign-up">Sign Up</a></span>

              <input type="submit" value="Log In" class="btn text-white btn-block btn-primary" id="login" name="login">
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
  <script>
    $('#login').click(function(event) {
        event.preventDefault();
        var formData = $('#login-form').serialize()+ '&userid=' + $('#userid').val() + '&password=' + $('#password').val();
      $.ajax({
        type: 'POST',
        url: 'dblogin.php',
        data: formData,
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                alert('Login Successful!\n Generate keys now ^_^');
                window.location.href = 'security.php';
            } else {
                alert('Error: ' + response.error);
            }
        },
        error: function(error) {
          console.error(error);
          // Handle errors
        }
      });
    });
  </script>
  <script>
      // Add a click event listener to the Sign Up link
      $('.sign-up').click(function() {
          // Redirect the user to signup.php
          window.location.href = 'signup.php';
      });

      $('.forgot-pass').click(function() {
          // Prompt the user to enter their email
          var userEmail = prompt('Enter your email:');

          // Check if the user entered an email
          if (userEmail) {
              // Now you can do something with the user's email, such as sending a reset password link
              // For example, you can make an AJAX request to your server to handle the forgot password logic
              // Replace the placeholder URL with the actual endpoint on your server
              $.ajax({
                  url: 'reset_password.php',
                  method: 'POST',
                  data: {email: userEmail},
                  success: function (response) {
                      // Handle the success response, e.g., show a message to the user
                      alert('Password reset email sent successfully.');
                      // Prompt the user to enter the OTP code
                      var userCode = prompt('Enter the OTP code sent to your email:');

                      // Check if the user entered an OTP code
                      if (userCode) {
                          // Now you can verify the OTP code entered by the user
                          // Make another AJAX request to your server to verify the OTP code
                          // Replace the placeholder URL with the actual endpoint on your server
                          $.ajax({
                              url: 'verify_otp.php',
                              method: 'POST',
                              data: { email: userEmail, code: userCode },
                              success: function(verificationResponse) {
                                  // Handle the verification response from the server
                                  if (verificationResponse === 'success') {
                                      // If the OTP code is correct, proceed to the next page
                                      window.location.href = 'update_password.php';
                                  } else {
                                      // If the OTP code is incorrect, show an error message
                                      alert('Incorrect OTP code. Please try again.');
                                  }
                              },
                              error: function(error) {
                                  // Handle the error response from the server
                                  alert('Failed to verify OTP code. Please try again.');
                              }
                          });
                      }
                  },
                  error: function (error) {
                      // Handle the error response, e.g., show an error message
                      alert('Failed to send password reset email. Please try again.');
                  }
              });
          }
      });
  </script>
  </body>
</html>