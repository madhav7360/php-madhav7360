
<?php
session_start();

$config = include 'config.php';


$con = mysqli_connect($config['host'], $config['user'], $config['pass'], $config['db']);

$query = "select * from list";
$resultcheck = mysqli_query($con, $query);

if (isset($_POST['submit'])) {

    $mailId = $_POST['mail'];
    if (!filter_var($mailId, FILTER_VALIDATE_EMAIL)) {
        echo ("<p style='color:red'> $mailId is not a valid email address </p>");
    } else {

        $_SESSION['email'] = $mailId;
       
        $_SESSION['confirm_visit'] = 1;

        header("Location: otp.php");
            
        
    }
}
?>

<!-- ***** PHP Ends ***** -->

