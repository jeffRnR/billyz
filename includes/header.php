<?php
// Start the session at the very beginning of the file


// Set your timezone
date_default_timezone_set('Africa/Nairobi');

// Get the current date and time
$current_date = date("l, d F Y");
$current_time = date("h:i A");

// Fetch the user's details (mock data for now)
$username = isset($_SESSION['username']) ? $_SESSION['username'] : 'Guest';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>College Management System</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body>
    <header>
        <div class="logo">
            <img src="../assets/images/logo.png" alt="Logo"> <!-- Add your logo image here -->
            <h1>Billyz College</h1>
        </div>
        <div class="header-right">
            <div class="date-time">
                <p><?php echo $current_date; ?></p>
                <p><?php echo $current_time; ?></p>
            </div>
            <div class="notifications">
                <i class="fas fa-bell"></i>
                <span class="notification-count">3</span> <!-- Example notification count -->
            </div>
            <div class="profile">
                <i class="fas fa-user-circle"></i>
                <span><?php echo $username; ?></span>
            </div>
        </div>
    </header>
</body>

</html>