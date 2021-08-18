<?php
//
if (isset($_SERVER['SERVER_ADDR']) && isset($_SERVER['REMOTE_ADDR']))
{
if($_SERVER['REMOTE_ADDR'] != $_SERVER['SERVER_ADDR']  ){
    exit("Access Denied");
}


$config = include 'config.php';

$con = mysqli_connect($config['host'], $config['user'], $config['pass'], $config['db']);

$query = "select * from list";
$resultcheck = mysqli_query($con, $query);
$rows = mysqli_fetch_all($resultcheck, MYSQLI_ASSOC);
//                                                                     For 0 subscription

if ($rows == 0)

 {
exit('Subscription list empty');

}
else

{

//                                                                    FETCHING COMIC
    $comic_no = rand(0, 614);
    $url = "https://xkcd.com/" . $comic_no . "/info.0.json";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_URL, $url);
    $res = curl_exec($ch);
    $response = json_decode($res);
    $url = $response->img;
    $image = './assets/' . $response->num . ".png";
    $fimage = fopen($image, 'w+');
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_FILE, $fimage);
    curl_exec($ch);
    curl_close($ch);
    fclose($fimage);

//                                                                   MAILING PROCESS

    $name = "Comic Subscription";
    $subject = "XKCD Comic";
    $base64str = base64_encode(file_get_contents($image));
    $headers = array(
        'Authorization: Bearer ' . $config['API_KEY'],
        'Content-Type: application/json',
    );
    $data = array(
        "personalizations" => array(
        ),
        "from" => array(
            "email" => "500070080@stu.upes.ac.in",
        ),
        "subject" => $subject,
        "content" => array(
            array(
                "type" => "text/html",
                "value" => "Click<a href='http://xkcd-subscription.gvidhyahostel.com/unsubscribe.php'> here </a> to unsubscribe",
            ),
        ),
        "attachments" => array(
            array(
                "content" => $base64str,
                "type" => "image/png",
                "filename" => "comic",
                "disposition" => "attachment",
                "content_ID" => "image-attachment",
            ),
        ),
    );

    $query = "select * from list";
    $resultcheck = mysqli_query($con, $query);
    $rows = mysqli_fetch_all($resultcheck, MYSQLI_ASSOC);
    foreach ($rows as $row) {
        $newdata = array(
            "to" => array(
                array(
                    "email" => $row['mailId'])));

        $data["personalizations"][] = $newdata;
    }

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://api.sendgrid.com/v3/mail/send");
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $response = curl_exec($ch);
    curl_close($ch);

//DELETING IMAGE
    unlink($image);

    echo $response;
}
}
else {
    exit("Error, Please try later");}