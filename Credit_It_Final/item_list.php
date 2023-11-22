<?php
    require 'connection.php';
    if(!isset($_SESSION['email']))
    {
        header("location:index.php");
    }
    $hash_id = sha1($_SESSION['email']);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Item list</title>
    <link rel="icon" href="./images/logo2.png" type="image/x-icon" integrity="sha384-...snip..."/>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fuzzy+Bubbles&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
        integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="item_list.css">
    <style>
    form {
        display: flex;
        flex-direction: column;
        align-items: center; /* Center the form content horizontally */
        margin-top: 20px; /* Add some spacing from the top */
    }
</style>

</head>
<body>
<?php include 'nav.php'?>
<a href="update_credit.php">
        <button class="back-button" type="close">&times;</button>
    </a>
    <h1 style="text-align:left; font-size: 28px;color:#fc0352;">Item List</h1>

<form id="login-form" action="" method="POST">
    <div class="mb-3">
        <div class="input-container">
            <select id="selectedname" class="form-select" name="selectedname" required onchange="this.form.submit()">
                <option value="" disabled selected>Select customer &#8595;</option>
                <?php
                $result = mysqli_query($connection, "SELECT f_name, l_name FROM customers WHERE hash_id='$hash_id'");
                while ($row = mysqli_fetch_assoc($result)) {
                    $fullName = $row['f_name'] . ' ' . $row['l_name'];
                    echo '<option value="' . $fullName . '">' . $fullName . '</option>';
                }
                ?>
            </select>
        </div>
    </div>
</form>

<!-- Your existing code... -->
<style>
    /* Add these styles to enhance the appearance of the select element */
    .input-container {
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .form-select {
        appearance: none; /* Remove default appearance */
        padding: 10px;
        font-size: 16px;
        border: 1px solid #ccc;
        border-radius: 5px;
        background-color: white;
        width: 250px;
        margin-left: -580px; /* Adjust the margin as needed */
    }
    .form-select:focus {
        outline: none;
        border-color: #3498db; /* Highlight border color on focus */
    }

    /* Style the selected option */
    .form-select option:checked {
        background-color: #a8dadc; /* Highlight the selected option */
        font-weight: bold; /* Make the selected option text bold */
    }
</style>
<!-- Your existing code ... -->

<div class="box">
    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['selectedname'])) {
        $selectedname = $_POST['selectedname'];
        $unique_id = hash('md5', $selectedname . $hash_id);

        // Fetch items' information from the database based on the selected name
        $result = mysqli_query($connection, "SELECT items, amount, credit_time_date FROM credits WHERE hash_id='$hash_id' AND unique_id='$unique_id'");
        
        if (mysqli_num_rows($result) > 0) {
            $serial_number = 0;
            // Fetch and display the data in the table
            echo "<h2 style='text-align:left;'>Item list for customer '$selectedname'</h2>";
            echo "<table class='table table-me'>
                    <tr class='headings'>
                        <th>Sr. No.</th>
                        <th>Items</th>
                        <th>Amount (Rs)</th>
                        <th>Time</th>
                        <th>Date</th>
                        <th>Delete</th>
                    </tr>";
            
                    while ($row = mysqli_fetch_assoc($result)) 
                    {
                        $items = $row['items'];
                        $amount = $row['amount'];
                        $credit_time_date = $row['credit_time_date'];
                        $id=$credit_time_date;
                        list($credit_time, $credit_ampm, $credit_date) = explode(' ', $credit_time_date);

                        // Convert time to 24-hour format if needed
                        if ($credit_ampm === 'PM') {
                            list($hour, $minute, $second) = explode(':', $credit_time);
                            $hour = ($hour == 12) ? $hour : $hour + 12;
                            $credit_time = "$hour:$minute:$second";
                        }
                        echo '<tr>';
                        echo '<th>' . ++$serial_number . '</th>'; // Assuming you have this variable defined earlier
                        echo '<th>' . $items . '</th>';
                        echo '<th>' . $amount . '</th>';
                        echo '<th>' . $credit_time . '</th>'; // Display time
                        echo '<th>' . $credit_date . '</th>'; // Display date
                        // echo '<th><a href="delete-data"><abbr title="Delete Data"><i class="fa-solid fa-trash-can delete-opt" style="color: #ff2e2e;"></i></abbr></a></th>';
                        echo '<th><button class="delete-button" data-id="' . $id . '"><abbr title="Delete Data"><i class="fa-solid fa-trash-can delete-opt" style="color: #ff2e2e; font-size: 2em;"></i></abbr></button></th>';
                        echo '</tr>';
                    }
        } else {
            echo '<h1 style="color:#0a0e8f;">No credit to show.</h1>';
        }
    }
    ?>
</table>
</div>




<script>
    // Add an event listener to each delete button
    document.querySelectorAll('.delete-button').forEach(button => {
        button.addEventListener('click', function () {
            const entryId = this.getAttribute('data-id');
            const confirmed = confirm('Are you sure you want to delete this entry?');
            
            if (confirmed) {
                // Send an AJAX request to delete the entry
                const xhr = new XMLHttpRequest();
                xhr.open('POST', 'delete-entry.php', true);
                xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                xhr.onreadystatechange = function () {
                    if (xhr.readyState === 4 && xhr.status === 200) {
                        // Reload the page after successful deletion
                        location.reload();
                    }
                };
                xhr.send('id=' + entryId);
            }
        });
    });
</script>

</body>

</html>