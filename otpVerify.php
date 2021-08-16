<!DOCTYPE html>
<?php
session_start();

if ($_SESSION['confirm_visit'] != 2) {
    echo "resquested page has expired, you will be redirected to home page";
    header("Location: index.php");
    exit;
}


?>
<html lang="en">

<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link rel="stylesheet" type="text/css" href="./assets/style.css" title="Default">
<title>xkcd Comics Subscription</title>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<link rel="shortcut icon" href="https://xkcd.com/s/919f27.ico" type="image/x-icon">
<link rel="icon" href="https://xkcd.com/s/919f27.ico" type="image/x-icon">

    <title>Comics Subscription</title>
</head>

<body>
<div id="topContainer" class="box">

<div id="ctitle"><img style="width: -webkit-fill-available;" src="./assets/cover.png" alt="cover photo"></div>
<div id="transcript" style="display: none"></div>
</div>
<div id="middleContainer">
<div id="middleLeft">
 <div id="masthead">
<span><a href="https://xkcd.com/"><img src="./assets/logo.png" alt="xkcd.com logo" height="83" width="185"></a></span>
</div>
<div id="news">
<div id="xkcdBanner"><a href="https://blacklivesmatter.com/"><img src="./assets/blm.png" style="
    height: 110px;
"></a></div>

</div>
</div>
<div id="middleRight">
<div id="masthead" style="
    padding: 15px;
">

<span id="slogan">A webcomic of romance,<br> sarcasm, math, and language.</span>
</div>
<div id="form">
<ul class="comicNav">

    <!-- ***** Form Start ***** -->


      
           <form action="" method="POST">
                                <li><label for="otp "> OTP: </label></li>
                                <li><input type="text" name="otp" id="otp" required=" "></li>
                                  <li><button class="main-button" name="submit" type="submit"> Submit OTP</button></li>  
                                    
                               


                               

            </form>
            </ul>

</div>
</div>
<div id="bgLeft" class="bg box"></div>
<div id="bgRight" class="bg box"></div>
</div>
       
    <!-- ***** Form End ***** -->



<!-- ***** PHP Start ***** -->

<?php

$config = include 'config.php';

$con = mysqli_connect($config['host'], $config['user'], $config['pass'], $config['db']);


if (isset($_POST['submit']) && isset($_POST['otp'])) {
    
    $otp = $_POST['otp'];
   
  

    $emailId = $_SESSION['email'];
    if ($otp == $_SESSION['otp']) {


        $check = "select * from list where mailId='$emailId'";
        $resultcheck = mysqli_query($con, $check);

        $row = mysqli_num_rows($resultcheck);
        



        if ($_SESSION['case'] == 'unsubscribe') {
            echo "unsubscribe" . "<br>";
            if ($row == 0) {
                $_SESSION['messege'] = 'No active subscription on this email id';
                $_SESSION['process'] = 3;
                header("Location: index.php");
            }
            else {
            $query = "delete from list where mailId = '$emailId'";
            $result = mysqli_query($con, $query);
            if ($result == 1) {
                $_SESSION['messege'] = 'Unsubscribed Sucessfully.';
                $_SESSION['process'] = 3;
                header("Location: index.php");

            }
        }
        } else if ($_SESSION['case'] == 'subscribe') {
            echo "subscribe" . "<br>";
            if ($row == 1) {
                $_SESSION['messege'] = 'Already Subscribed';
                $_SESSION['process'] = 3;
                header("Location: index.php");
            }
            else {
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
}

?>

<!-- ***** PHP Ends ***** -->

</body>

</html>

