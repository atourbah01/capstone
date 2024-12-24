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
                            <h3>Dive In to <strong>Color Chat</strong></h3>
                            <p class="mb-4"> Color your conversations, color your life!</p>
                        </div>
                        <form action="#" method="post">
                            <div class="form-group first">
                                <label for="servername">Server Name</label>
                                <input type="text" class="form-control" id="servername" name="servername">

                            </div>
                            <div class="form-group first">
                                <label for="ip">IP Address</label>
                                <input type="text" class="form-control" id="ip" name="ip">
                            </div>
                            <div class="form-group first">
                                <label for="port">Port Number</label>
                                <input type="text" class="form-control" id="port" name="port">
                            </div>

                            <div class="form-group first">
                                <label for="sys">System</label>
                                <select class="form-control" id="sys" name="sys">
                                    <option value=""></option>
                                    <option value="Windows">Windows</option>
                                    <option value="Mac OS X">Mac OS X</option>
                                    <option value="Linux">Linux</option>
                                </select>

                            </div>
                            <div class="form-group first">
                                <label for="bits">Bits</label>
                                <select class="form-control" id="bits" name="bits">
                                    <option value=""></option>
                                    <option value="1024">1024</option>
                                    <option value="2048">2048</option>
                                    <option value="3072">3072</option>
                                    <option value="4096">4096</option>
                                </select>
                            </div>

                            <div class="d-flex mb-5 align-items-center">
                                <label class="control control--checkbox mb-0">
                                    <span class="caption" id="toggle-icon">
                                        <span class="toggle-text">
                                            Light Mode
                                        </span>
                                    </span>
                                    <input type="checkbox" id="mode" name="mode"/>
                                    <div class="control__indicator"></div>
                                </label>
                            </div>

                            <!--
                            <div class="form-group last mb-4">
                              <label for="password">Password</label>
                              <input type="password" class="form-control" id="password">

                            </div>

                            <div class="d-flex mb-5 align-items-center">
                              <label class="control control--checkbox mb-0"><span class="caption">Remember Me</span>
                                <input type="checkbox" checked="checked"/>
                                <div class="control__indicator"></div>
                              </label>
                              <span class="ml-auto"><a href="#" class="forgot-pass">Forgot Password</a></span>
                            </div>-->

                            <input type="submit" value="Submit" class="btn text-white btn-block btn-primary" id="Submit" name="Submit">

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
    //const toggleSwitch = document.querySelector('input[type="checkbox"]');
    const toggleSwitch = document.getElementById('mode');
    const toggleIcon = document.getElementById('toggle-icon');
    const darkModeStyle = document.getElementById('dark-mode-style');

    // Function to toggle dark mode
    function toggleDarkMode() {
        document.body.classList.toggle('theme-dark');
        darkModeStyle.innerHTML = document.body.classList.contains('theme-dark')
            ? `
            body.theme-dark {
              background-color: #121212;
              color: #ffffff;
            }

            .navbar.theme-dark {
              background-color: #333333;
            }

          `
            : '';
        // Change text and icon
        toggleIcon.children[0].textContent = document.body.classList.contains('theme-dark') ? 'Dark Mode' : 'Light Mode';
        if (toggleIcon.children[1]) {
            toggleIcon.children[1].classList.toggle('fa-sun');
            toggleIcon.children[1].classList.toggle('fa-moon');
        }
    }

    // Event Listener for the switch
    toggleSwitch.addEventListener('change', toggleDarkMode);

    // Check Local Storage For Theme
    const currentTheme = localStorage.getItem('theme');
    if (currentTheme === 'dark') {
        toggleSwitch.checked = true;
        toggleDarkMode();
    }

    // Event listener for key generation button
    /*var servername=document.getElementById("servername");
    var ip=document.getElementById("ip");
    var sys=document.getElementById("sys");
    var bits=document.getElementById("bits");
    var mode=document.getElementById("mode");*/
    $('#Submit').click(function(event) {
        event.preventDefault();
        var formData = $('#login-form').serialize()+ '&servername=' + $('#servername').val() + '&ip=' + $('#ip').val() + '&port=' + $('#port').val() + '&bits=' + $('#bits').val()+ '&mode=' + $('#mode').val()+ '&sys=' + $('#sys').val();
        $.ajax({
            type: 'POST',
            url: 'generate_key.php',
            data: formData,
            dataType: 'json',
            success: function(response) {

                if (response.success) {
                    alert('Keys Generated Successfully:\n You can chat now ^_^');
                    window.location.href = '../Chat/main.php';
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
</body>
</html>
