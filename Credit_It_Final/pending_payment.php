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
    <title>Pending Payment</title>
    <link rel="icon" href="./images/logo2.png" type="image/x-icon" integrity="sha384-...snip..."/>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fuzzy+Bubbles&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="pending_payment.css">
</head>
<body>
<?php include "nav.php";?>
<a href="home.php">
    <button class="back-button" type="close">&times;</button>
</a>

    <div class="box">
        <table class="table table-me" >
                    
            <tr class="headings" >
                <th>S.N</th>
                <th>Customer Name</th>
                <th>Pending Amount</th>
                <th>Last PurchaseTime</th>
                <th>Last Purchase</th>
                <th>Details</th>
            </tr>
            <?php
            $hash_id = sha1($_SESSION['email']);
        // Fetch items' information from the database based on the selected name
        $result = mysqli_query($connection, "SELECT f_name, l_name, total_credit, last_credit_time_date FROM customers WHERE hash_id='$hash_id'");
        
        if (mysqli_num_rows($result) > 0) {
            $serial_number = 0;
            // Fetch and display the data in the table
                    while ($row = mysqli_fetch_assoc($result)) 
                    {
                        $f_name = $row['f_name'];
                        $l_name = $row['l_name'];
                        $full_name = $f_name . " " . $l_name;
                        $pending_amount = $row['total_credit'];
                        $last_credit_time_date = $row['last_credit_time_date'];
                        list($credit_time, $credit_ampm, $credit_date) = explode(' ', $last_credit_time_date);

                        // Convert time to 24-hour format if needed
                        if ($credit_ampm === 'PM') {
                            list($hour, $minute, $second) = explode(':', $credit_time);
                            $hour = ($hour == 12) ? $hour : $hour + 12;
                            $credit_time = "$hour:$minute:$second";
                        }
                        echo '<tr>';
                        echo '<th>' . ++$serial_number . '</th>'; // Assuming you have this variable defined earlier
                        echo '<th>' . $full_name . '</th>';
                        echo '<th>' . $pending_amount . '</th>';
                        echo '<th>' . $credit_time . '</th>'; // Display time
                        echo '<th>' . $credit_date . '</th>'; // Display date
                        echo '<th><a href="manage_customer.php"><abbr title="Edit data"><i class="fa-solid fa-file-pen" style="color: #ff2e2e;"></i></abbr></a></th>';
                        echo '</tr>';
                    }
        } else {
            echo '<h1 style="color:#0a0e8f;">No data to show.</h1>';
        }
    ?>
        </table>
    </div>
    

<!-- js used in nav  -->
    <script>
        let subMenu = document.getElementById("subMenu");
            function toggleMenu(){
                subMenu.classList.toggle("open-menu");
            }

        document.addEventListener("DOMContentLoaded", function() {
            let logoElement = document.getElementById("logo");
            logoElement.addEventListener("click", function() {
                window.location.href = "home.html"; // Change the URL to desired destination
            });
        });

// Add your js here
    


    </script>
</body>
</html>