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
    <title>Customer Details</title>
    <link rel="icon" href="./images/logo2.png" type="image/x-icon" integrity="sha384-...snip..."/>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Aclonica&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="customer_detail.css">
<body>
    <?php include 'nav.php'; ?>
    <a href="manage_customer.php">
        <button class="back-button" type="close">&times;</button>
    </a>
    <!--container-->
    <div class="container">
        <?php
            $selectedName = $_SESSION['selectedName'];
            $hash_id = sha1($_SESSION['email']);
            $unique_id = hash('md5', $selectedName . $hash_id);
            $result = mysqli_query($connection,"SELECT f_name, l_name, mobile, address, total_credit FROM customers WHERE hash_id='$hash_id' AND unique_id='$unique_id'");
            
            if (mysqli_num_rows($result) > 0) 
            {
                $row = mysqli_fetch_assoc($result);
                $fullName = $row['f_name'] . ' ' . $row['l_name'];
                $mobile = $row['mobile'];
                $address = $row['address'];
                $totalCredit = $row['total_credit'];
        ?>
        <h1><?php echo $fullName; ?></h1>
        <a style="text-decoration: none;" href="tel:+91<?php echo $mobile; ?>"><h2 style="color: blue; text-decoration: none;">+91 <?php echo $mobile; ?></h2></a>
        <p><?php echo $address; ?><br>Total balance: <?php echo $totalCredit; ?></p>
        <div class="button-group">
            <a href="update_customer_detail.php" class="styled-button" id="update-button">Update</a>
            <a href="delete_account.php" class="styled-button" id="delete-button">Delete</a>
        </div>
        <?php
            } else {
                echo "<p>No data found.</p>";
            }
        ?>
</div>
</body>
</head>
</html>  