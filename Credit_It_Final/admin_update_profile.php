<?php
    require 'connection.php';
    if(!isset($_SESSION['email']))
    {
        header("location:index.php");
    }

    $firstName = "";
    $lastName = "";
    $shopName = "";
    $shopAddress = "";
    
    $errorMessage = "";

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $email = $_SESSION['email'];
        $oldPassword = $_POST['old-password'];
        $hash_pass = sha1($oldPassword);
        //echo $email ."<br>". $oldPassword ."<br>". $hash_pass;
        $sql = mysqli_query($connection,"SELECT * FROM admin WHERE email ='$email' AND password = '$hash_pass'");
        if (mysqli_num_rows($sql)==1) 
        {
            $newPassword = $_POST['new-password'];
            $confirmedPassword = $_POST['confirm-password'];
            //echo $newPassword ."<br>". $confirmedPassword ."<br>".$email ."<br>". $oldPassword ."<br>". $hash_pass;
            if ($newPassword !== $confirmedPassword) {
                echo '<script>
                alert("Passwords did not match!\nPlease try again.....");
                </script>';
            } else {
                $f_name = $_POST['first-name'];
                $l_name = $_POST['last-name'];
                $shopName = $_POST['shop-name'];
                $shopAddress = $_POST['shop-address'];
                $fullname = $f_name . " " . $l_name;
                $hash_pass = sha1($newPassword);
                // echo $fullname ."<br>".$f_name ."<br>". $l_name ."<br>".$shopName ."<br>". $shopAddress; 
                $updateResult = mysqli_query($connection,"UPDATE admin SET name = '$fullname', shop_name = '$shopName',shop_add = '$shopAddress',password ='$hash_pass'   WHERE email = '$email'");
                
                if ($updateResult) {
                    echo '<script>
                    alert("Sccessfully Updated!\nPlease login again!");
                    </script>';
                    session_destroy();
                    echo '<script>window.location.href = "login.php"</script>';
                } else {
                    echo '<script>
                    alert("Error in Updated!\nPlease login again!");
                    </script>';
                }
            }
        } else {
            echo '<script>
            alert("Incorrect Password!\nPlease try again.....");
            </script>';
        }
        
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="admin_update_profile.css">
    <title>Update Profile</title>
    <link rel="icon" href="./images/logo2.png" type="image/x-icon" integrity="sha384-...snip..."/>
</head>
<body>
    <header>
        <h1>Update Profile</h1>
    </header>
    <main>
        <a href="home.php">
            <button class="back-button" type="close">&times;</button>
        </a>
        <section class="update-section">
            <div class="update-form">
                <?php if ($errorMessage !== ""): ?>
                    <p style="color: red;"><?php echo $errorMessage; ?></p>
                <?php endif; ?>
                <form action="" method="POST" onsubmit="return validatePassword()">
                    <label for="first-name">First Name:</label>
                    <input type="text" id="first-name" name="first-name" placeholder="Enter your first name" required value="<?php echo $firstName; ?>">

                    <label for="last-name">Last Name:</label>
                    <input type="text" id="last-name" name="last-name" placeholder="Enter your last name" required value="<?php echo $lastName; ?>">

                    <label for="shop-name">Shop Name:</label>
                    <input type="text" id="shop-name" name="shop-name" placeholder="Enter your shop name" required value="<?php echo $shopName; ?>">

                    <label for="shop-address">Shop Address:</label>
                    <input type="text" id="shop-address" name="shop-address" placeholder="Enter your shop address" required value="<?php echo $shopAddress; ?>">

                    <label for="old-password">Old Password:</label>
                    <input type="password" id="old-password" name="old-password" placeholder="Enter old password" required>
                    
                    <label for="new-password">New Password:</label>
                    <input type="password" id="new-password" name="new-password" placeholder="Enter new password" required>
                    
                    <label for="confirm-password">Confirm Password:</label>
                    <input type="password" id="confirm-password" name="confirm-password" placeholder="Confirm new password" required>

                    <button type="submit">Update</button>
                </form>
            </div>
        </section>
    </main>
    <footer>
        <p>&copy; 2023 Your Website. All rights reserved.</p>
    </footer>
</body>
</html>
