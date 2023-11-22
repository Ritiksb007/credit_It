<?php
    require 'connection.php';
    if(!isset($_SESSION['email']))
    {
        header("location:index.php");
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="home.css">
    <link rel="stylesheet" href="nav.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
          integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <title>Home Page</title>
    <link rel="icon" href="./images/logo2.png" type="image/x-icon" integrity="sha384-...snip..."/>
</head>
<body class="xyz">
<?php include 'nav.php'; ?>
        <div class="cbuttons">
            <a href="customer.php">
                <button class="new-credit">
                    <i class="fa-regular fa-credit-card fa-xl"></i>
                    New Credit
                </button>
            </a>
            <a href="manage_customer.php">
                <button class="mng-cstmr">
                    <i class="fa-solid fa-users fa-xl"></i>
                    Manage Customer
                </button>
            </a>
            <a href="update_credit.php">
                <button class="update-credit">
                    <i class="fa-solid fa-pen-to-square fa-xl"></i>
                    Update Credit
                </button>
            </a>
            <a href="pending_payment.php">
                <button class="pending-payments">
                    <i class="fa-solid fa-handshake fa-xl"></i>
                    Pending Payments
                </button>
            </a>
            <a href="#">
                <button class="backup">
                    <i class="fa-solid fa-boxes-packing fa-xl"></i>
                    Backups
                </button>
            </a>
        </div>
    </div>
</body>
</html>
