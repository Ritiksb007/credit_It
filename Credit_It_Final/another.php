<!DOCTYPE html>
<html>
<head>
    <!-- Your head content -->
</head>
<body>
    <?php
        session_start(); // Start the session
        if(isset($_SESSION['selectedName'])) {
            $selectedName = $_SESSION['selectedName'];
            echo "<p>You selected: " . $selectedName . "</p>";
        }
    ?>
    <!-- Rest of your HTML content -->
</body>
</html>
