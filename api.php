<?php
//
if (isset($_SERVER['SERVER_ADDR']) && isset($_SERVER['REMOTE_ADDR']))
{
    if ($_SERVER['REMOTE_ADDR'] != $_SERVER['SERVER_ADDR'])
    {
        exit('Access Denied');
    }
    date_default_timezone_set('Asia/kolkata');
$time = date('h:i:s a');
    $config = include __DIR__ . './config.php';

    $con = mysqli_connect($config['host'], $config['user'], $config['pass'], $config['db']);

    $query = 'select * from list';
    $resultcheck = mysqli_query($con, $query);
    $rows = mysqli_fetch_all($resultcheck, MYSQLI_ASSOC);
    //                                                                     For 0 subscription
    if(empty($rows))

    {
        exit('Subscription list empty');

    }
    else

    {

        //                                                                    FETCHING COMIC

        //Generating random comic's url
        $url = 'https://c.xkcd.com/random/comic/';
        $data = ( get_headers($url, 1));
        $url= $data['Location']['1'].'info.0.json';

        //Fetching comic's details from generated url        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        $res = curl_exec($ch);
        $response = json_decode($res);
        $url = $response->img;
        $image = './assets/' . $response->num . '.png';
        $fimage = fopen($image, 'w+');
       
        //Fetching and stroing image from link provided in details
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_FILE, $fimage);
        curl_exec($ch);
        curl_close($ch);
        fclose($fimage);

        //                                                                   MAILING PROCESS
        $SECRET_STRING='123';
        $name = 'Comic Subscription';
        $subject = 'XKCD Comic';
        $base64str = base64_encode(file_get_contents($image));
        $headers = array(
            'Authorization: Bearer ' . $config['API_KEY'],
            'Content-Type: application/json',
        );
        $title= $response->safe_title;
           $serial= $response->num;
           $image_link= $response->img;    
        //                                                                  Loop
        $query = 'select * from list';
        $resultcheck = mysqli_query($con, $query);
        $rows = mysqli_fetch_all($resultcheck, MYSQLI_ASSOC);
        foreach ($rows as $row)
        {
        $link = "http://".$_SERVER['HTTP_HOST']."/php-madhav7360/unsubscribe.php?id=".$row['mailId']."&validation_hash=".md5($row['mailId'].$config['KEY']);
           

        
        $data = array(
            'personalizations' => array(
                array(
                'to' => array(
                    array(
                        'email' => $row['mailId']
                    )
                )
            )
            ) ,
            'from' => array(
                'name' => $config['name'],
                'email' => $config['from'],
            ) ,
            'subject' => $subject,
            'content' => array(
                array(
                     'type' => 'text/html',
                     'value' => '<p>Comic Title : '.$title.'</p>
                     <p>Serial number : '.$serial.'</p>
                     <img alt="comic" src='.$image_link.' />
                     <p> Click<a href='.$link.'> here </a> to unsubscribe</p>
                      ['.$time.'] End of message<p>'.$_SERVER['HTTP_HOST'].'/php-madhav7360/unsubscribe.php</p>',
                     ) 
                     ) ,
            'attachments' => array(
                array(
                    'content' => $base64str,
                    'type' => 'image/png',
                    'filename' => 'comic',
                    'disposition' => 'attachment',
                    'content_ID' => 'image-attachment',
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

        
}
//DELETING IMAGE
unlink($image);

echo $response;
}
}
else
{
    exit('Error, Please try later');
}

