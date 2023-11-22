<?php
    require 'connection.php';
    if(!isset($_SESSION['email']))
    {
        header("location:index.php");
    }
    if(!empty($_POST))
    {
        //error_reporting(0);
        $items = $_POST['items'];
        $amount = $_POST['amount'];
        $selectedname = $_POST["selectedname"];
        date_default_timezone_set("Asia/Kolkata");
        $currentDateTime = date("h:i:s A d/m/Y", time());
        $hash_id = sha1($_SESSION['email']);      
        $unique_id = hash('md5', $selectedname . $hash_id);
        //echo $selectedname ."<br>". $items ."<br>". $amount."<br>". $hash_id ."<br>". $unique_id."<br>". $currentDateTime;
        $sql = mysqli_query($connection,"INSERT INTO credits(hash_id,unique_id,items,amount,credit_time_date) VALUES ('$hash_id','$unique_id','$items','$amount','$currentDateTime')");
        if ($sql)
        {
                $sqli = mysqli_query($connection, "SELECT total_credit FROM customers WHERE unique_id='$unique_id'");
                if ($sqli) {
                    $row = mysqli_fetch_assoc($sqli);
                    $new_credit = (float)$row['total_credit']; // Convert to float
                } else {
                    // Handle the case where the query fails
                }
                $amount = (float)$amount;
                $new_credit += $amount;
            $sql = mysqli_query($connection, "UPDATE customers SET total_credit = '$new_credit', last_credit_time_date = '$currentDateTime' WHERE unique_id = '$unique_id'");
            echo '<script>
                alert("Items successfully added!");
                /*window.location.href = "customer.php";*/
                </script>';
        }else{
            echo '<script>
            alert("An error occurred!");
            /*window.location.href = "add_customer.php";*/ // Change to your home page URL
            </script>';
            }

    }
   
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Credit</title>
    <link rel="icon" href="./images/logo2.png" type="image/x-icon" integrity="sha384-...snip..."/>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
        integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href='https://fonts.googleapis.com/css?family=Aclonica' rel='stylesheet'>
    <link rel="stylesheet" href="new_credit.css">
    <link rel="stylesheet" href="	https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css">
    <!-- HTML -->
    <style>
        .center-container {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 50vh; /* This will make sure the container takes the full viewport height */
}

    </style>
</head>

<body>
    <div class="hero">
        <nav>
            <img src="images/logo.png" class="logo">
            <?php
                $username = $_SESSION['email'];
                $result = mysqli_query($connection,"SELECT shop_name FROM admin WHERE email = '$username'");
                $row = mysqli_fetch_assoc($result);
                $value = $row['shop_name'];
                echo "<div style='margin: 5px;color: #000000;font-size: 40px;font-weight: 700;'>".$value."</div>";
            ?>
            <div class="circle">
                <img src="images/profile.png" alt="vaibhav" class="user-pic" onclick="toggleMenu()">
            </div>
            <div class="sub-menu-wrap" id="subMenu">
                <div class="sub-menu">
                    <div class="user-info">
                        <div class="circle">
                            <img src="images/profile.png" alt="Vaibhav" class="user-pic">
                        </div>
                        <h3>Username</h3>
                    </div>
                    <hr>
                    <a href="update_customer_detail.php" class="sub-menu-link">
                        <img src="images/profile.png" alt="">
                        <p>Update Profile</p>
                        <span> > </span>
                    </a>
                    <a href="help.php" class="sub-menu-link" target="_blank">
                        <img src="images/help.png" alt="">
                        <p>Help</p>
                        <span> > </span>
                    </a>
                    <a href="logout.php" class="sub-menu-link">
                            <img src="images/logout.png" alt="">
                            <p>Logout</p>
                            <!-- <span> > </span> -->
                    </a>
                </div>
            </div>
        </nav>
        <div class="center-container">
            <div class="login-container">
                <form  id="login-form" action="" method="POST">
                    <div class="mb-3">
                    <select id="selectedname" class="form-select" name="selectedname" required>
                        <option value="" disabled selected>Select customer</option>
                        <?php
                            $hash_id = sha1($_SESSION['email']);
                            $result = mysqli_query($connection,"SELECT f_name, l_name FROM customers WHERE hash_id='$hash_id'");
                            while ($row = mysqli_fetch_assoc($result))
                            {
                                $fullName = $row['f_name'] . ' ' . $row['l_name'];
                                echo '<option value="' . $fullName .'">' . $fullName . '</option>';
                            }
                        ?>
                    </select>
                    </div>
                    <div class="mb-3">
                        <label for="items" class="form-label">Items</label>
                        <textarea class="form-control" id="items" rows="3" name="items"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="amount" class="form-label">Total Amount</label>
                        <input class="form-control" type="number" id="Amount" name="amount" required min="0">
                    </div>
                    <input class="btn btn-primary" type="submit" value="ADD Credit">
                </form>
            </div>
        </div>
        <a href="customer.php">
            <button class="back-button" type="close">&times;</button>
        </a>

                <!-- Javascript -->
                <script>
                    let subMenu = document.getElementById("subMenu");
                    function toggleMenu() {
                        subMenu.classList.toggle("open-menu");
                    }
                </script>
</body>

</html>