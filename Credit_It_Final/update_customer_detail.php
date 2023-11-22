<?php
require 'connection.php';
if (!isset($_SESSION['email'])) {
    header("location:index.php");
}

$selectedName = $_SESSION['selectedName'];
$hash_id = sha1($_SESSION['email']);
$unique_id = hash('md5', $selectedName . $hash_id);

$result = mysqli_query($connection, "SELECT f_name, l_name, mobile, address FROM customers WHERE hash_id='$hash_id' AND unique_id='$unique_id'");

if ($result && mysqli_num_rows($result) > 0)
{
    $row = mysqli_fetch_assoc($result);
    $f_name = $row['f_name'];
    $l_name = $row['l_name'];
    $mobile = $row['mobile'];
    $address = $row['address'];
} else {
        echo "<script>alert('no data found');</script>";
        // Handle the case where no data is found
    }

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $newMobile = mysqli_real_escape_string($connection, $_POST['phoneNumber']);
    $newAddress = mysqli_real_escape_string($connection, $_POST['address']);

    $updateQuery = "UPDATE customers SET mobile='$newMobile', address='$newAddress' WHERE hash_id='$hash_id' AND unique_id='$unique_id'";

    if (mysqli_query($connection, $updateQuery)) {
        echo "<script>alert('Update successful'); window.location.href = 'customer_detail.php';</script>";
        exit;
    } else {
        echo "Error updating record: " . mysqli_error($connection);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Customer</title>
    <link rel="icon" href="./images/logo2.png" type="image/x-icon" integrity="sha384-...snip..."/>
    <link rel="stylesheet" href="update_customer_detail.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Aclonica&display=swap" rel="stylesheet">
    <!-- <link href="https://fonts.googleapis.com/css2?family=Fuzzy+Bubbles&display=swap" rel="stylesheet"> -->
    
</head>
<body>
<?php include "nav.php"?>
<a href="customer_detail.php">
        <button class="back-button" type="close">&times;</button>
    </a>
<!-- Place your content here -->

<div class="close-alignment">
    <a href="yet-to-be-added">
        <button class="btn-close" type="close"></button>
    </a>
</div>

<div class="form-container">
    <h1> Update Details of "<?php echo $f_name." ".$l_name;?>".</h1>
    <br><br>
    <form action="" method="POST">
        <label for="firstName">First Name:</label>
        <input type="text" id="firstName" name="firstName" value="<?php echo $f_name; ?>" readonly>


        <label for="lastName">Last Name:</label>
        <input type="text" id="lastName" name="lastName" value="<?php echo $l_name; ?>" readonly>

        <label for="phoneNumber">Phone Number:</label>
        <input type="tel" id="phoneNumber" name="phoneNumber" value="<?php echo $mobile; ?>" required>

        <label for="address">Address:</label>
        <textarea id="address" name="address" required><?php echo $address; ?></textarea>

        <div class="Add-btn-wrapper">
            <button class="btn-Update" type="submit">Update</button>
        </div>
    </form>
</div>

<!-- js used in nav -->
    <script>
        let subMenu = document.getElementById("subMenu");
            function toggleMenu(){
                subMenu.classList.toggle("open-menu");
            }

        document.addEventListener("DOMContentLoaded", function() {
            let logoElement = document.getElementById("logo");
            logoElement.addEventListener("click", function() {
                window.location.href = "index.html"; // Change the URL to your desired destination
            });
        });

    </script>
</body>
</html>