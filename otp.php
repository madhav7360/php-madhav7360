<?php
session_start();

$otp = rand(100000, 999999); //OTP generate
$email = $_SESSION['email'];
$_SESSION['otp'] = $otp;
//                                                                   MAILING PROCESS
$config = include __DIR__ . '/config.php';
$body = '<p>We have received a request for subscription of your email address to xkcd comics mailing list.</p><p>Your OTP is ' . $otp.'</p><p>If you do not wish to be subscribed no action is required.</p>';
$name = 'OTP';
$subject = 'Email Verification : OTP - ' . $otp;

    
$headers = array(
    'Authorization: Bearer ' . $config['API_KEY'],
    'Content-Type: application/json',
);

$data = array(
    'personalizations' => array(
        array(
            'to' => array(
                array(
                    'email' => $email,
                ) ,
            ) ,
        ) ,
    ) ,
    'from' => array(
        'name' => $config['name'],
        'email' => $config['from'],
    ) ,
    'subject' => $subject,
    'content' => array(
        array(
            'type' => 'text/html',
            'value' => $body,
        ) ,
    ) ,
);
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://api.sendgrid.com/v3/mail/send');
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$response = curl_exec($ch);
curl_close($ch);
header('Location: otpVerify.php');
die;

