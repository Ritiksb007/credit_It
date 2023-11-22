<?php
require 'connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = $_POST['id'];
    
    // Perform the deletion query here based on the provided ID
    mysqli_query($connection, "DELETE FROM credits WHERE credit_time_date='$id'");
}
?>
