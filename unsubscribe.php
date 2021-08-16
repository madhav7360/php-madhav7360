<!DOCTYPE html>
<html><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link rel="stylesheet" type="text/css" href="./assets/style.css" title="Default">
<title>xkcd Comics Subscription</title>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<link rel="shortcut icon" href="https://xkcd.com/s/919f27.ico" type="image/x-icon">
<link rel="icon" href="https://xkcd.com/s/919f27.ico" type="image/x-icon">


</head>
<body>
    
    <div id="topContainer" class="box">

        <div id="ctitle"><img style="width: -webkit-fill-available;" src="./assets/cover.png" alt="cover photo"></div>
        <div id="transcript" style="display: none"></div>
    </div>
<div id="middleContainer">
<div id="middleLeft">
 <div id="masthead">
<span><a href="https://xkcd.com/"><img src="./assets/0b7742.png" alt="xkcd.com logo" height="83" width="185"></a></span>
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

<form action="verify.php" method="POST">
<li> <input type="email" name="mail" id="mail"  required></li>
<li> <button name="submit" type="submit" > Register </button></li>
</form>
<li>

    <?php
    session_start();
    if (isset($_SESSION['messege'])) {
        echo $_SESSION['messege'];
        session_unset();
    }
    $_SESSION['confirm_visit'] = 0;
    $_SESSION['case'] = 'unsubscribe';
    ?>

</li>
</ul>

</div>
</div>
<div id="bgLeft" class="bg box"></div>
<div id="bgRight" class="bg box"></div>
</div>

<!-- Layout by Ian Clasbey, davean, and chromakode -->

</body></html>
