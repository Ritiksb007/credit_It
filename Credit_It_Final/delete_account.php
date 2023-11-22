<?php
    require 'connection.php';
    if(!isset($_SESSION['email']))
    {
        header("location:index.php");
    }
    $selectedName = $_SESSION['selectedName'];
    $hash_id = sha1($_SESSION['email']);
    $unique_id = hash('md5', $selectedName . $hash_id);
       
    if ($_SERVER["REQUEST_METHOD"] == "POST") 
    {
        if ($_POST["confirmation"] === "yes") {
            // Assuming $hash_id and $unique_id are already defined
            $deleteQuery = "DELETE FROM customers WHERE hash_id='$hash_id' AND unique_id='$unique_id'";

            if (mysqli_query($connection, $deleteQuery)) {
                // Redirect to a success page or another appropriate action
                echo '<script>alert("Successfully deleted"); window.location.href = "home.php";</script>';
                exit;
            } else {
                // Handle the error scenario
                echo "Error deleting user: " . mysqli_error($connection);
            }
        }
    }

?>
<!DOCTYPE html>
<html>
<head>
    <title>Delete Account</title>
    <link rel="icon" href="./images/logo2.png" type="image/x-icon" integrity="sha384-...snip..."/>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0; /* Reset default margin */
            padding: 0; /* Reset default padding */
        }
        
        .container {
            max-width: 500px;
            margin: 50px auto; /* Add top margin for spacing */
            padding: 20px;
            background-color: white;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        
        h2 {
            color: #333;
            margin-top: 0; /* Remove default margin */
        }
        
        form {
            margin-top: 20px;
        }
        
        button, a {
            background-color: red;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            margin-right: 10px;
        }
        
        button:hover, a:hover {
            background-color: darkred;
        }
        
        a {
            background-color: #666;
        }
    </style>
</head>
<body>
<?php include "nav.php"?>
    <div class="container">
        <h2>Are you sure you want to delete "<?php echo $selectedName; ?>" account?</h2>
        <form method="post" action="">
            <input type="hidden" name="confirmation" value="yes">
            <button type="submit">Yes</button>
            <a href="customer_detail.php">No</a>
        </form>
    </div>
</body>
</html>