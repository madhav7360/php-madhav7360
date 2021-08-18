<?php
session_start();

$otp = rand(100000, 999999); //OTP generate
$email = $_SESSION['email'];
$_SESSION['otp'] = $otp;
//                                                                   MAILING PROCESS
$config = include __DIR__ . './config.php';
$body = "Your OTP is " . $otp;
$name = "OTP";
$subject = "Email Verification : OTP - " . $otp;

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
                ) ,
            ) ,
        ) ,
    ) ,
    "from" => array(
        "email" => "500070080@stu.upes.ac.in",
    ) ,
    "subject" => $subject,
    "content" => array(
        array(
            "type" => "text/html",
            "value" => $body,
        ) ,
    ) ,
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
die;

