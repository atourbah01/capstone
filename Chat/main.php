<?php session_start();?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Chat System</title>


    <link rel="stylesheet" href="style.css" type="text/css" />


    <script src="https://code.jquery.com/jquery-3.3.1.js" crossorigin="anonymous"></script>
    <style>
        body {
            background-color: cyan;
        }

        /* Styles for title */
        .title-container {
            text-align: center;
            margin-bottom: 20px;
        }

        .title {
            font-size: 36px;
            font-weight: bold;
            color: #333; /* Change color as desired */
            text-transform: uppercase;
            letter-spacing: 2px;
            border-bottom: 1px solid #333; /* Underline effect */
            padding-bottom: 10px;
            display: inline-block;
            margin-bottom: 10px;
            font-family: 'Montserrat', sans-serif;
        }
        /* Style for logout button */
        .logout-btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #ff4d4d;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .logout-btn:hover {
            background-color: #e60000;
        }


        /* Style for details button */
        .details-btn{
            position: absolute;
            right: 10px;
            padding: 2px 2px;
            display: inline-block;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .details-btn:hover {
            background-color: #45a049;
        }
        /* Style for chathistory div */
        .chathistory {
            position: relative;
            /* Add other styles as needed */
        }
    </style>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
    <script>
        function showDetails(publicKey) {
            alert(publicKey);
        }
    </script>
    <!-- Dark Mode Script -->
    <script>
        $(document).ready(function(){
            // Check if dark mode is enabled
            var darkMode = '<?php echo isset($_SESSION["mode"]) && $_SESSION["mode"] === "off" ? "true" : "false"; ?>';

            // Function to toggle dark mode
            function toggleDarkMode() {
                var body = $('body');
                var navbar = $('.navbar');
                if (darkMode === 'true') {
                    body.addClass('theme-dark');
                    navbar.addClass('theme-dark');
                } else {
                    body.removeClass('theme-dark');
                    navbar.removeClass('theme-dark');
                }
            }

            // Toggle dark mode on page load
            toggleDarkMode();
        });
    </script>
</head>
<body>

<div class="centeralised">
    <div class="title">Color Chat</div>

    <div class="chathistory"></div>

    <div class="chatbox">

        <form action="" method="POST">

            <textarea class="txtarea" id="message" name="message"></textarea>

        </form>

    </div>
    <a href="logout.php" class="logout-btn">Logout</a>

</div>


<script>

    $(document).ready(function(){
        loadChat();

    });



    $('#message').keyup(function(e){


        var message = $(this).val();

        if( e.which == 13 ){

            $.post('handlers/ajax.php?action=SendMessage&message='+message, function(response){

                loadChat();
                $('#message').val('');

            });

        }

    });


    function loadChat()
    {
        $.post('handlers/ajax.php?action=getChat', function(response){

            $('.chathistory').html(response);

        });
    }


    setInterval(function(){
        loadChat();
    }, 2000);

</script>

</body>
</html>