<?php
    require_once './includes/db.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us</title>
    <?php require_once './includes/head.php'; ?>
</head>
<body>
    <?php require_once './includes/navbar.php'; ?>
    <div class="container">
        <div class="row bg-white shadow border m-5">
            <h1 class="text-center" style="color: green; margin-top: .5em;"><b>ABOUT US</b></h1>
            <div class="col-md-6 col-sm-6">
                <img src="./images/aboutus.png" class="img-fluid">
            </div>
            <div class="col-md-6 col-sm-6">
                <div class="text-center p-4" style="margin-top: 3em;">
                <h2>We deliver clean, green, and fresh agricultural products.</h2>
                <h5>An online farmers' market that connects buyer directly to local farmers and producers. 
                    Browse and purchase fresh vegetables and fruits, and other relative agriculture products.</h5>
                </div>
            </div>
        </div>
        <div class="row border bg-white m-5">
            <h1 class="text-center pb-2" style="color: green; margin-top: .5em;"><b>CONTACT US</b></h1>
            <div class="col-md-3 col-sm-3 text-center">
                <a href=""><span><ion-icon name="logo-facebook" style="font-size: 2em;"></ion-icon></span></a>
                <p>FACEBOOK</p>
            </div>
            <div class="col-md-3 col-sm-3 text-center">
                <a href=""><span><ion-icon name="call-outline" style="font-size: 2em;">></ion-icon></span></a>
                <p>TEL. NUMBER</p>
            </div>
            <div class="col-md-3 col-sm-3 text-center">
                <a href=""><span><ion-icon name="location-outline" style="font-size: 2em;"></ion-icon></span></a>
                <p>ADDRESS</p>
            </div>
            <div class="col-md-3 col-sm-3 text-center">
                <a href=""><span><ion-icon name="mail-outline" style="font-size: 2em;"></ion-icon></span></a>
                <p>Email</p>
            </div>
        </div>
    </div>
    <?php 
    include './includes/chat_canvas.php';
    ?>
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script> -->
    <script src="./js/chat_canvas.js"></script>
    <script src="./js/chat_icon.js"></script>
    <!-- <script src="./js/send_btn.js"></script> -->
</body>
<footer class="bg-dark text-white text-center p-4" style="margin-top: 5em; height: 5em;">
    <h6>E-FarmErce</h6>
    <p>&copy; 2023 All rights reserved</p>
</footer>

</html>