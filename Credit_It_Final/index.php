<?php
    require 'connection.php';
    if(isset($_SESSION['email']))
    {
        header("location:home.php");
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Credit_It | Easy And Safe</title>
    <link rel="icon" href="./images/logo2.png" type="image/x-icon" integrity="sha384-...snip..."/>
    <link rel="stylesheet" href="index.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fuzzy+Bubbles&display=swap" rel="stylesheet">

</head>
<body>
<!-- navigation bar -->
    <div class="container">
        <div class="logo" onclick="">
            <a href="index.html"><img src="images/logo.png" alt="logo" width="100" /></a>
        </div>
        <nav>
            <button class="aboutus" onclick="window.open('about_us.php', '_blank');">About Us</button>
            <button class="contactus" onclick="window.location.href='#footer-contact';">Contact Us</button>
        </nav>
    </div>
    
<!-- middle part of html page -->
    <div class="middle">
        <div class="context">
            "Smart India ka, <br>
            Smart Udhar Bahi Khata!<br>
            Rakhe udhar-darj, bhugtan-raji ki 
            khabar.<br>
            Asaan aur tez, payment ka safar."
        </div>
        <div class="mbuttons">
            <a href="create.php">
                <button class="create">Create Account</button>
            </a>
            <a href="login.php">
                <button class="login">Log In</button>
            </a>
        </div>
    </div>
<!-- footer -->
    <div class="fcontainer">
        <div class="flogo">
            <a href="index.html"><img src="./images/logo.png" alt="flogo" /></a>
            </div>
        <nav>
        <div id="footer-contact" class="footer-contact">
            Contact Us
            <a href="tel:+918446648561"><br>☎ +91 000 000 0000</a>
            <a href="mailto:creditit@gmail.com? subject:Contact Mail"><br>&#9993; creditit@gmail.com</a>
        </div>
        </nav>
    </div>
</body>
</html>