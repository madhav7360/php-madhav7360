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
       <form action="" method="POST">
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
if (isset($_POST['submit'])) {
$config = include 'config.php';
$con = mysqli_connect($config['host'], $config['user'], $config['pass'], $config['db']);
    $mailId = $_POST['mail'];
    if (!filter_var($mailId, FILTER_VALIDATE_EMAIL)) {
        echo ("<p style='color:red'> $mailId is not a valid email address </p>");
    } 
    
    else {
        $check = "select * from list where mailId='$mailId'";
        $resultcheck = mysqli_query($con, $check);

        $row = mysqli_num_rows($resultcheck);
        if ($row == 1) {
           echo 'Already Subscribed';
           

        } else {
           echo 'Not Subscribed';
        }
    }
}
?>

<!-- ***** PHP Ends ***** -->



</body>
</html>
