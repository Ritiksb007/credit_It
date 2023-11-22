<?php
// Assuming you have already established a database connection

require 'connection.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
         // Get input values from the form
         $f_name =$_POST['fname'];
         $l_name =$_POST['lname'];
         $phone =$_POST['phone'];
         $email =$_POST['email'];
         $sh_name =$_POST['sh_name'];
         $sh_add =$_POST['sh_add'];
         $password =$_POST['password'];
         $con_password =$_POST['con_password'];
         $pass =sha1($_POST['password']);
         $hash_id =sha1($email);
         $space = ' ';
         $full_name = $f_name.$space.$l_name;

    try {
        if ($password==$con_password) 
        {
        // echo $f_name."<br>".$l_name."<br>".$phone."<br>".$email."<br>".$sh_name."<br>".$sh_add."<br>".$password."<br>".$con_password."<br>".$pass."<br>".$hash_id."<br>".$full_name;
        
        $sql = mysqli_query($connection,"INSERT INTO admin(name, phone_no, email, shop_name, shop_add, password, hash_id) VALUES ('$full_name','$phone','$email','$sh_name','$sh_add','$pass','$hash_id')");
        error_reporting(0);
        if ($sql) {
            // echo "<script>alert('Success!');</script>";
            // header("Location: login.php");
            echo '<script>
                    alert("Account Successfully Created!\nPlease Login Now.....");
                    window.location.href = "index.php"; // Change to your home page URL
                </script>';
        }
        else
        {
            echo '<script>
                    alert("An error occurred : Email Alredy Exist!");
                    window.location.href = "create.php";
                </script>';
        }
        }else{
            echo '<script>
            alert("Password Did Not match");
            window.location.href = "create.php"; // Change to your home page URL
            </script>';
        }        
        } catch (Exception $e) {
            echo "<script>alert('Email Alredy Exist!');</script>";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="create.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@600&display=swap" rel="stylesheet">
    <title>Create Account</title>
    <link rel="icon" href="./images/logo2.png" type="image/x-icon" integrity="sha384-...snip..."/>
</head>
<body>
    <div class="Container">
        <form action="" method="post">
            <div class="content">
                <div class="input-box">
                    <label for="fname">First Name</label>
                    <input type="text" placeholder= "👤 Enter First Name" id="fname" name="fname" required>
                </div>
                <div class="input-box">
                    <label for="lname">Last Name</label>
                    <input type="text" placeholder="👤 Enter Last Name" id="lname" name="lname" required>
                </div>
                <div class="input-box">
                    <label for="phone">Phone</label>
                    <input type="tel" maxlength="10"  id="phone" placeholder="☎ Enter Contact Number" name="phone" required>
                </div>
                <div class="input-box">
                    <label for="email">Email Address</label>
                    <input type="email" placeholder="✉️ Enter Your Valid Email Address" id="email" name="email" required>
                </div>
                <div class="input-box">
                    <label for="sh_name">Shop Name</label>
                    <input type="text" placeholder="🛒 Enter Shop Name" id="sh_name" name="sh_name" required>
                </div>
                <div class="input-box">
                    <label for="sh_add">Shop Address</label>
                    <input type="text" placeholder="📍 Enter Shop Address" id="sh_add" name="sh_add" required>
                </div>
                <div class="input-box">
                    <label for="password">Password</label>
                    <input type="password" minlength="4" id="password" placeholder="🔒 Enter New Password" name="password" autocomplete="off" required>
                </div>
                <div class="input-box">
                    <label for="con_password">Confirm Password</label>
                    <input type="password" minlength="4" id="con_password" placeholder="🔒 Confirm Your Password" name="con_password" autocomplete="off" onkeyup="check()" required>
                    <error id="alert"></error>
                </div>
            </div>
            
            <button class="btn-submit" type="submit">Submit</button>
        </form>
            <a href="index.php">
                <button class="btn-close" type="close">&times;</button>
            </a>
    </div>
</body>
</html>