<?php
    require 'connection.php';
    if(!isset($_SESSION['email'])) {
        header("location:index.php");
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Credit Customer</title>
    <link rel="icon" href="./images/logo2.png" type="image/x-icon" integrity="sha384-...snip..."/>
    <link rel="stylesheet" href="customer.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fuzzy+Bubbles&display=swap" rel="stylesheet">
</head>
<body>
    <?php include 'nav.php'; ?>
    <div class="ccmiddle">
        <div class="ccbuttons">
            <a href="add_customer.php">
                <button class="addcos">Add Customer</button>
            </a>
            <a href="new_credit.php">
                <button class="newcre">New Credit</button>
            </a>
            <a href="home.php">
                <button class="back-btn">Back</button>
            </a>
        </div>
    </div>
</body>
</html>
