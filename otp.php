<?php
session_start();

if ($_SESSION['confirm_visit'] != 1 ) {

    echo "requested page has expired, you will be redirected to home page";
    header("Location: index.php");
    exit;
}
$_SESSION['confirm_visit'] = 2;

$rndno = rand(100000, 999999); //OTP generate
$email = $_SESSION['email'];
$_SESSION['otp'] = $rndno;
//                                                                   MAILING PROCESS
$config = include 'config.php';
$body = "Your Verification code is " . $rndno;
$name = "OTP";
$subject = "Email Verification";

$headers = array(
    'Authorization: Bearer ' . $config['API_KEY'],
    'Content-Type: application/json',
);

$data = array(
    "personalizations" => array(
        array(
            "to" => array(
                array(
                    "email" => $email,
                ),
            ),
        ),

    ),
    "from" => array(
        "email" => "500070080@stu.upes.ac.in",
    ),
    "subject" => $subject,
    "content" => array(
        array(
            "type" => "text/html",
            "value" => $body,
        ),
    ),
);

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://api.sendgrid.com/v3/mail/send");
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$response = curl_exec($ch);
curl_close($ch);
header("Location: otpVerify.php");
