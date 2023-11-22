<!-- THIS NAVIGATION BAR NOT PRESENT IN NEW CREDIT PAGE AND MANAGE CUSTOMER PAGE THEY HAVE SEPERATE NAV BAR -->
<?php
    
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    $connection = mysqli_connect('localhost', 'root', '', 'creditit');

    // Check if the user is logged in and the database connection is successful
    if(isset($_SESSION['email']) && $connection){
        $username = $_SESSION['email'];
        $result = mysqli_query($connection, "SELECT shop_name FROM admin WHERE email = '$username'");
        $row = mysqli_fetch_assoc($result);
        $value = $row['shop_name'];
    } else {
        header("location:index.php");
        exit(); // Terminate further execution
    }    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="nav.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
          integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <title>Navigation</title>
    <link rel="icon" href="./images/logo2.png" type="image/x-icon" integrity="sha384-...snip..."/>
</head>
<body>
    <nav>
        
    <img src="images/logo.png" class="logo">
    <div style='margin: 5px;color: #000000;font-size: 40px;font-weight: 700;'><?php echo $value; ?></div>
        <div class="circle">
            <img src="images/profile.png" alt="vaibhv" class="user-pic" onclick="toggleMenu()">
        </div>

        <div class="sub-menu-wrap" id="subMenu">
            <div class="sub-menu">
                <div class="user-info">
                    <div class="circle">
                        <img src="images/profile.png" alt="Vaibhav" class="user-pic">
                    </div>
                    <h3><?php       
                        $hash_id = sha1($_SESSION['email']);
                        $result = mysqli_query($connection, "SELECT name FROM admin WHERE hash_id = '$hash_id'");
                        $row = mysqli_fetch_assoc($result);
                        $value = $row['name']; echo $value;?>
                    </h3>
                </div>
                <hr>
                <a href="admin_update_profile.php" class="sub-menu-link">
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
                </a>
            </div>
        </div>
    </nav>
    <script>
        let subMenu = document.getElementById("subMenu");
        function toggleMenu() {
            subMenu.classList.toggle("open-menu");
        }
    </script>
</body>
</html>
