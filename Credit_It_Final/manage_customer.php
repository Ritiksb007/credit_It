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
    <title>Manage Customer</title>
    <link rel="icon" href="./images/logo2.png" type="image/x-icon" integrity="sha384-...snip..."/>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="manage_customer.css">
    <style>
    .back-button {
    font-family: 'Bahnschrift SemiBold', Arial, sans-serif;
    position: absolute;
    top: 95px;
    right: 30px;
    padding: 10px 15px;
    background-color: transparent;
    color: black;
    border-color: black;
    border-radius: 4px;
    font-size:60px;
    font-weight: bold;
    cursor: pointer;
    }
    .back-button:hover {
        background-color:black;
        color: white;
    }
    </style>
</head>
<body>
<div class="hero">
        <a href="home.php">
            <button class="back-button" type="close">&times;</button>
        </a>
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
                <img src="images/profile.png" alt="vaibhv" class="user-pic" onclick="toggleMenu()">
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
                            <!-- <span> > </span> -->
                        </a>
                    </div>
            </div>
        </nav>
</div>

<div class="container">
        <h1>Customer List</h1>
        <div class="search-box">
            <p class="customers-label">Customers</p>
            <input type="text" id="searchInput" name="searchInput" placeholder="Search customer" autocomplete="off">
            <button>Search</button>
        </div>
    </div>

<form method="post">
        <!-- Other form fields -->
        <!-- Hidden input field to store selected name -->
        <input type="hidden" id="selectedName" name="selectedName" value="">
    
    <!-- Customer List -->
    <ul class="customer-list" id="customerList">
            <?php
                $hash_id = sha1($_SESSION['email']);
                $result = mysqli_query($connection,"SELECT f_name, l_name FROM customers WHERE hash_id='$hash_id'");
                while ($row = mysqli_fetch_assoc($result)) {
                $fullName = $row['f_name'] . ' ' . $row['l_name'];
                echo '<li value="' . $fullName . '">' . $fullName . '</li>';
                }
            ?>
    </ul>
</form>

    <!-- ... (rest of your content) ... -->

    <!-- JavaScript code -->
    <script>
                let subMenu = document.getElementById("subMenu");
                function toggleMenu(){
                                subMenu.classList.toggle("open-menu");
                            }

            document.addEventListener("DOMContentLoaded", function () {
            function searchNames() {
                const input = document.getElementById("searchInput");
                const filter = input.value.toUpperCase();
                const list = document.getElementById("customerList");
                const items = list.getElementsByTagName("li");

                for (let i = 0; i < items.length; i++) {
                    const name = items[i].innerText;
                    if (name.toUpperCase().indexOf(filter) > -1) {
                        items[i].style.display = "";
                    } else {
                        items[i].style.display = "none";
                    }
                }
            }

            const input = document.getElementById("searchInput");
            input.addEventListener("keyup", searchNames);
        });

    </script>
    
    <!-- JavaScript code -->
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const items = document.querySelectorAll(".customer-list li");

        items.forEach(item => {
            item.addEventListener("click", function () {
                const selectedName = item.textContent;
                document.getElementById("selectedName").value = selectedName;
                document.querySelector("form").submit();
            });
        });

        // Rest of your existing code
    });
</script>
<?php
    if (isset($_POST['selectedName'])) {
        $selectedName = $_POST['selectedName'];
        $_SESSION['selectedName'] = $selectedName; // Store in a session variable
        echo "<script>
                window.location.href = 'customer_detail.php' ;
            </script>";
    }
?>

</body>
</html>
