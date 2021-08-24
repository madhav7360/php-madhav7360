<!DOCTYPE html>
<html lang='en'>
  <head>
    <link
      rel='stylesheet'
      type='text/css'
      href='./assets/style.css'
      title='Default'
    />
    <title>xkcd Comics Subscription</title>

    <link
      rel='shortcut icon'
      href='https://xkcd.com/s/919f27.ico'
      type='image/x-icon'
    />
    <link rel='icon' href='https://xkcd.com/s/919f27.ico' type='image/x-icon' />
  </head>
  <body>
    <?php
session_start();

if (isset($_POST['submit'])) {

    $mailId = $_POST['mail'];
    if (!filter_var($mailId, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['message']='Invalid email address.';
    } else {

        $_SESSION['email'] = $mailId;
       
       

        header('Location: otp.php');
        exit;
            
        
    }
}
?>

    <div id='topContainer' class='box'>
      <div id='ctitle'>
        <img
          style='width: -webkit-fill-available'
          src='./assets/cover.png'
          alt='cover photo'
        />
      </div>
      <div id='transcript' style='display: none'></div>
    </div>
    <div id='middleContainer'>
      <div id='middleLeft'>
        <div id='masthead'>
          <span
            ><a href='https://xkcd.com/'
              ><img
                src='./assets/logo.png'
                alt='xkcd.com logo'
                height='83'
                width='185' /></a
          ></span>
        </div>
        <div id='news'>
          <div id='xkcdBanner'>
            <a href='https://blacklivesmatter.com/'
              ><img src='./assets/blm.png' style='height: 110px'
            /></a>
          </div>
        </div>
      </div>
      <div id='middleRight'>
        <div id='masthead' style='padding: 15px'>
          <span id='slogan'
            >A webcomic of romance,<br />
            sarcasm, math, and language.</span
          >
        </div>
        <div id='form'>
          <ul class='comicNav'>
            <form action='' method='POST'>
              <div><label for='mail'>Email address : </label></div>
              <li>
                <input
                  type='email'
                  name='mail'
                  id='mail'
                  placeholder='email@address.com'
                  required
                />
              </li>
              <li><button name='submit' type='submit'>Subscribe</button></li>
            </form>
            <li>
              <?php
   
    if (isset($_SESSION['message'])) {
        echo $_SESSION['message'];
        session_unset();
    }
    
    ?>
            </li>
          </ul>
        </div>
      </div>
      <div id='bgLeft' class='bg box'></div>
      <div id='bgRight' class='bg box'></div>
    </div>

    <div id='bottom' class='box'>
      <?php 
      //Generating random comic's url
      $url = "https://c.xkcd.com/random/comic/";
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, $url);
      curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

      curl_exec($ch);
      $url = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);
      $url = $url.'info.0.json';

      //Fetching comic's details from generated url
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
      curl_setopt($ch, CURLOPT_URL, $url);
      $res = curl_exec($ch);
      $response = json_decode($res);
      curl_close($ch);
echo "<div id='ctitle'><img
        style='width: -webkit-fill-available'
        src= $response->img 
        alt='Random comic'
      />
    </div>
    "; 
    ?>
    

    <!-- Layout by Ian Clasbey, davean, and chromakode -->
  </body>
</html>
