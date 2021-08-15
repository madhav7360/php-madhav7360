<!DOCTYPE html>
<?php
session_start();

if ($_SESSION['confirm_visit'] != 2) {
    echo "resquested page has expired, you will be redirected to home page";
    header("Location: index.php");
    exit;
}
$_SESSION['confirm_visit'] = 3;

?>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Comics Subscription</title>
</head>

<body>

    <!-- ***** Form Start ***** -->


       <div class="container">
           <form action="" method="POST">
                                <div class="user-box">
                                    <input type="text" name="otp" id="otp" required=" ">
                                    <label for="otp "> OTP: </label>
                                </div>


                                <div>
                                    <button class="main-button" name="submit" type="submit"> Submit </button>
                                </div>


            </form>
            </div>
       
    <!-- ***** Form End ***** -->



<!-- ***** PHP Start ***** -->

<?php

$config = include 'config.php';

$con = mysqli_connect($config['host'], $config['user'], $config['pass'], $config['db']);


if (isset($_POST['submit'])) {
    
    $otp = $_POST['otp'];
   
  

    $emailId = $_SESSION['email'];
    if ($otp == $_SESSION['otp']) {

        if ($_SESSION['case'] == 'unsubscribe') {
            echo "unsubscribe" . "<br>";
            $query = "delete from list where mailId = '$emailId'";
            $result = mysqli_query($con, $query);
            if ($result == 1) {
                $_SESSION['messege'] = 'Unsubscribed Sucessfully.';
                $_SESSION['process'] = 3;
                header("Location: index.php");

            }

        } else if ($_SESSION['case'] = 'subscribe') {
            echo "subscribe" . "<br>";
            $query = "insert into list (mailId) values ('$emailId')";
            $result = mysqli_query($con, $query);
            if ($result == 1) {
                $_SESSION['messege'] = 'Subscribed Sucessfully. A XKCD comic will be sent to you every 5 min';
                $_SESSION['process'] = 3;
                header("Location: index.php");

            }

        }

    }
}

?>

<!-- ***** PHP Ends ***** -->

</body>

</html>

