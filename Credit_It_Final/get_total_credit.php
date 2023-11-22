<?php
require 'connection.php';

if (isset($_POST['customerName'])) {
    $selectedName = $_POST['customerName'];

    $hash_id = sha1($_SESSION['email']);
    $unique_id = hash('md5', $selectedName . $hash_id);

    $query = "SELECT total_credit FROM customers WHERE hash_id='$hash_id' AND unique_id='$unique_id'";
    $result = mysqli_query($connection, $query);

    if ($result) {
        $row = mysqli_fetch_assoc($result);
        echo $row['total_credit']; // Echo the total credit value
    } else {
        echo "Error fetching total credit.";
    }
}
?>
