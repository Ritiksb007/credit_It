<?php
    require 'connection.php';
    if(isset($_SESSION['email']))
    {
        header("location:home.php");
    }
    if(!empty($_POST))
    {
        //error_reporting(0);
        $email = $_POST['username'];
        $pass = $_POST['password'];
        $hash_pass = sha1($pass);
        //echo $email ."<br>". $pass ."<br>". $hash_pass;
        $sql = mysqli_query($connection,"SELECT * FROM admin WHERE email ='$email' AND password = '$hash_pass'");
        //echo mysqli_num_rows($sql);//if user exist then show 1 otherwise 0
        if (mysqli_num_rows($sql)==1) {
            //session set
            $_SESSION['email'] = $_POST['username'];
            echo '<script>
            alert("Login Successful.....");
            window.location.href = "home.php"; // Change to your home page URL
            </script>';
        } else {
            echo '<script>
            alert("Incorrect credentials Or account not exist!\nPlease try again.....");
            window.location.href = "login.php"; // Change to your home page URL
            </script>';
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@600&display=swap" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Aclonica' rel='stylesheet'>
    <link rel="stylesheet" href="login.css">
    <!-- <link rel="stylesheet" href="styles.css"> -->
    <title>Login</title>
    <link rel="icon" href="./images/logo2.png" type="image/x-icon" integrity="sha384-...snip..."/>
</head>
<body>
    <div class="center-container">
        <div class="login-container">
            <h1>Log In</h1>
            <form id="login-form" action="" method="POST">
                <label for="username">Username:</label>
                <input type="email" placeholder="Enter Your Email Id" id="username" name="username" required>

                <label for="password">Password:</label>
                <input type="password" placeholder="Enter Your Password" id="password" name="password" required>

                <button type="submit">Log In</button>
            </form>
            <a href="index.php">
                <button class="back-button" type="close">&times;</button>
            </a>
        </div>
    </div>
    <div class="tilted-image-container">
        <img src="./images/login_image.png">
    </div>   
    </div>
</body>
</html>
