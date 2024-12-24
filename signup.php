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
                            <h3>Sign Up to <strong>Color Chat</strong></h3>
                            <p class="mb-4"> Color your conversations, color your life!</p>
                        </div>
                        <form action="#" method="post">
                            <div class="form-group first">
                                <label for="firstname">First Name</label>
                                <input type="text" class="form-control" id="firstname" name="firstname">

                            </div>
                            <div class="form-group first">
                                <label for="lastname">Last Name</label>
                                <input type="text" class="form-control" id="lastname" name="lastname">

                            </div>
                            <div class="form-group first">
                                <label for="email">Email</label>
                                <input type="text" class="form-control" id="email" name="email">

                            </div>
                            <div class="form-group first">
                                <label for="userid">User ID (Unique)</label>
                                <input type="number" min="1" class="form-control" id="userid" name="userid">
                            </div>

                            <div class="form-group last mb-4">
                              <label for="password">Password</label>
                              <input type="password" class="form-control" id="password" name="password">

                            </div>
                            <div class="form-group last mb-4">
                                <label for="cpassword">Confirm Password</label>
                                <input type="password" class="form-control" id="cpassword" name="cpassword">

                            </div>


                            <span class="ml-auto"><a href="#" class="login">Login</a></span>

                            <input type="submit" value="Signup" class="btn text-white btn-block btn-primary" id="Signup" name="Signup">
                        </form>
                    </div>
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

<!-- Dark Mode Script -->
<script>

    $('#Signup').click(function(event) {
        event.preventDefault();
        var formData = $('#login-form').serialize()+ '&firstname=' + $('#firstname').val() + '&lastname=' + $('#lastname').val() + '&email=' + $('#email').val()+ '&userid=' + $('#userid').val()+ '&password=' + $('#password').val()+ '&cpassword=' + $('#cpassword').val();
        $.ajax({
            type: 'POST',
            url: 'dbsignup.php',
            data: formData,
            dataType: 'json',
            success: function(response) {

                if (response.success) {
                    alert('Sign Up Successful:\n You can login now');
                    window.location.href = 'index.php';
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
    $('.login').click(function() {
        // Redirect the user to signup.php
        window.location.href = 'index.php';
    });
</script>

</body>
</html>
