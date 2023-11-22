<?php
    require 'connection.php';
    if(!isset($_SESSION['email']))
    {
        header("location:index.php");
    }
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Get input values from the form
        $f_name =$_POST['firstname'];
        $l_name =$_POST['lastname'];
        $fullname = $f_name . " " . $l_name;
        $phone =$_POST['number'];
        $address =$_POST['address']; 
        date_default_timezone_set("Asia/Kolkata");
        $currentDateTime = date("h:i:s A d/m/Y", time());
        $hash_id = sha1($_SESSION['email']);      
        $unique_id = hash('md5', $fullname . $hash_id);

        //echo $f_name."<br>".$l_name."<br>".$phone."<br>".$address."<br>".'0'."<br>".$currentDateTime."<br>".$hash_id."<br>".$unique_id."<br>".'0'."<br>";

        try {
            $sqli = mysqli_query($connection, "SELECT * FROM customers WHERE hash_id='$hash_id' AND unique_id='$unique_id'");
            if($sqli){
                $sql = mysqli_query($connection,"INSERT INTO customers(f_name,l_name, mobile, address, total_credit,create_time_date, hash_id, unique_id,last_credit_time_date) VALUES ('$f_name', '$l_name','$phone','$address','0','$currentDateTime','$hash_id','$unique_id','$currentDateTime')");
                error_reporting(0);
                if ($sql)
                {
                    // echo "<script>alert('Success!');</script>";
                    // header("Location: login.php");
                    echo '<script>
                        alert("Customer successfully added!");
                        window.location.href = "customer.php";
                        </script>';
                }else{
                    echo '<script>
                    alert("An error occurred : Customer Alredy Exist 1111!");
                    window.location.href = "add_customer.php"; // Change to your home page URL
                    </script>';
                    }
                }else
            {
                echo '<script>
                        alert("An error occurred : Customer Alredy Exist2222!");
                        window.location.href = "add_customer.php"; // Change to your home page URL
                    </script>';
            }
        }catch (Exception $e) {    
            echo "<script>alert('Customer Alredy Exist!');</script>";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="add_customer.css">
    <title>Add Customer</title>
    <link rel="icon" href="./images/logo2.png" type="image/x-icon" integrity="sha384-...snip..."/>
    <script>
        function transformToUppercase(elementId) {
            const inputElement = document.getElementById(elementId);
            if (inputElement) {
                inputElement.value = inputElement.value.toUpperCase();
            }
        }
    </script>
</head>
<body>
    <?php include 'nav.php'; ?>
    <a href="customer.php">
        <button class="back-button" type="close">&times;</button>
    </a>
    <div class="hero">
        <h1> Add Customer</h1>
        <div class="form-container">
            <form action="" method="post">
            <label for="firstname">First Name:</label>
                <input type="text" id="firstname" name="firstname" required onblur="transformToUppercase('firstname')">

                <label for="lastname">Last Name:</label>
                <input type="text" id="lastname" name="lastname" required onblur="transformToUppercase('lastname')">

                <label for="number">Phone Number:</label>
                <input type="tel" id="number" name="number" required>

                <label for="address">Address:</label>
                <textarea id="address" name="address" required></textarea>

                <div class="Add-btn-wrapper">
                    <button class="btn-Add" type="submit">Add</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
