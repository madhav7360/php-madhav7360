<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comics Subscription</title>
</head>
<body>
<!-- ***** Form Starts ***** -->
       <form action="verify.php" method="POST">
            <div class="user-box">
                    <label for="mail"> Email id: </label>
                    <input type="email" name="mail" id="mail"  required>
                </div>
            
                <div>
                    <button class="btn" name="submit" type="submit"> Register </button>
                </div>

            </div>
        </form>
<!-- ***** Form Ends ***** -->

<!-- ***** PHP Starts ***** -->
<?php
session_start();

if (isset($_SESSION['messege'])) {
    echo $_SESSION['messege'];
    session_unset();
    session_destroy();
}

?>


<!-- ***** PHP Ends ***** -->



</body>
</html>
