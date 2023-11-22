<?php
    require 'connection.php';
    if(!isset($_SESSION['email']))
    {
        header("location:index.php");
    }

if (isset($_POST['paySubmit'])) {
    $selectedName = $_POST['customerSelect'];
    $paymentAmount = $_POST['paymentAmount'];
    date_default_timezone_set("Asia/Kolkata");
    $currentDateTime = date("h:i:s A d/m/Y", time());

    $hash_id = sha1($_SESSION['email']);
    $unique_id = hash('md5', $selectedName . $hash_id);

    $result = mysqli_query($connection,"SELECT total_credit FROM customers WHERE hash_id='$hash_id' AND unique_id='$unique_id'");

    if ($result) {
        $row = mysqli_fetch_assoc($result);
        $currentTotal = $row['total_credit'];

        // Deduct the payment amount from the total credit
        if ($paymentAmount > 0 && $paymentAmount <= $currentTotal) {
            $updatedTotal = $currentTotal - $paymentAmount;

            // Update the total_credit in the database
            $updateQuery = "UPDATE customers SET total_credit='$updatedTotal' WHERE hash_id='$hash_id' AND unique_id='$unique_id'";
            $updateResult = mysqli_query($connection, $updateQuery);

            $payment = mysqli_query($connection,"INSERT INTO payments (hash_id, unique_id, payment_amount, payment_date_time) VALUES ('$hash_id', '$unique_id','$paymentAmount', '$currentDateTime')");

            if ($updateResult) {
                echo "<script>alert('seccessfully updates. Remaining amount is Rs ".$updatedTotal.".');</script>";
                // Successfully updated, perform any further actions or display success message
            } else {
                echo "Error updating total credit in the database.";
            }
        } else {
            echo "<script>alert('Enter proper amount. Means it is either zero or exceeding payable amount');</script>";
        }
    } else {
        echo "Error fetching total credit from the database.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Credit</title>
    <link rel="icon" href="./images/logo2.png" type="image/x-icon" integrity="sha384-...snip..."/>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
        integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href='https://fonts.googleapis.com/css?family=Aclonica' rel='stylesheet'>
    <link rel="stylesheet" href="update_credit.css" type="text/css">
    <link rel="stylesheet" href="	https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css">
</head>
<!-- ... (Head section content) ... -->

<body style="background-color: #eafc28;">
<h1>Update Credit</h1>
<?php include "nav.php";?>
<a href="home.php">
    <button class="back-button" type="close">&times;</button>
</a>

<div class="center-container">
    <div class="login-container">
    <form action="" method="post">
        <div class="mb-3">
            <label for="customerSelect" class="form-label"></label>
            <select id="customerSelect" name="customerSelect" class="form-select">
                <option>-- -- Select Customer -- --</option>
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

        <div class="custom-input">
            <label for="totalbalance" class="custom-input">Total balance:</label>
            <input style="font-weight: bold;font-size: 18px;color: #ff6600; " type="text" id="totalbalance" name="totalbalance" class="form-control" aria-label="Amount" readonly>
        </div>

        <div class="mb-3">
            <label for="paymentAmount" class="form-label"></label>
            <input type="number" class="form-control" id="paymentAmount" name="paymentAmount" placeholder="Enter Amount">
        </div>
        
        <div class="text-center">
            <button type="submit" class="btn btn-warning" name="paySubmit">Pay</button>
        </div>
</form>
        <br><br>

        <div class="button-container">
            <a href="item_list.php">
            <button type="button" class="btn1">
                <i class="fa-regular fa-clipboard fa-xl"></i>
                &nbsp;&nbsp;Items List
            </button>
            </a>

            <button type="button" class="btn2">
                <a href="payment_history.php" style="text-decoration:none;color:black;";>
                <i class="fa-regular fa-address-card fa-xl"></i>
                &nbsp;Payment History
            </button>
            </a>
        </div>
        <script>
                document.addEventListener("DOMContentLoaded", function() {
                const customerSelect = document.getElementById("customerSelect");
                const totalBalanceInput = document.getElementById("totalbalance");
                customerSelect.addEventListener("change", function() {
                const selectedName = customerSelect.value;
                // Make an AJAX request to fetch total credit
                const xhr = new XMLHttpRequest();
                xhr.open("POST", "get_total_credit.php", true);
                xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xhr.onreadystatechange = function() 
                {
                    if (xhr.readyState === 4 && xhr.status === 200) {
                        totalBalanceInput.value = xhr.responseText; // Set the value of the input field
                    }
                };
                xhr.send("customerName=" + selectedName);
            });
        });
        </script>
    </div>
</div>

</body>
</html>