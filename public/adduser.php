<?php
session_start();
include '../includes/db_connect.php';
include '../includes/header.php';
include '../includes/mainsidebar.php';

function is_developer($role_id)
{
    return $role_id == 6; // Assuming 6 is Developer
}

if (!isset($_SESSION['role_id']) || !is_developer($_SESSION['role_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $role_id = mysqli_real_escape_string($conn, $_POST['role_id']);

    // Hash the password before storing it
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insert the user data into the database
    $sql = "INSERT INTO Users (username, email, password, role_id) VALUES ('$username', '$email', '$hashed_password', '$role_id')";

    if (mysqli_query($conn, $sql)) {
        $message = "User registered successfully!";
    } else {
        $message = "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}

// Fetch roles from the database
$roles_sql = "SELECT * FROM Roles";
$roles_result = mysqli_query($conn, $roles_sql);
?>
<!DOCTYPE html>
<html>

<head>
    <title>Developer Dashboard - College Management System</title>
    <link rel="stylesheet" type="text/css" href="../assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body>
    <div class="content">
        <h2>Welcome to the Developer Dashboard</h2>
        <div class="register-container">
            <h3>Create New User</h3>
            <form action="developer_dashboard.php" method="POST">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>

                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>

                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>

                <label for="role_id">Role:</label>
                <select id="role_id" name="role_id" required>
                    <?php
                    if (mysqli_num_rows($roles_result) > 0) {
                        while ($role = mysqli_fetch_assoc($roles_result)) {
                            echo "<option value='" . htmlspecialchars($role['role_id'], ENT_QUOTES, 'UTF-8') . "'>" . htmlspecialchars($role['role_name'], ENT_QUOTES, 'UTF-8') . "</option>";
                        }
                    } else {
                        echo "<option value=''>No roles available</option>";
                    }
                    ?>
                </select>

                <button type="submit">Register User</button>
            </form>
            <?php
            if (isset($message)) {
                echo "<div class='message'>$message</div>";
            }
            ?>
        </div>
    </div>
    <?php include '../includes/footer.php'; ?>

    <?php
    // Close the database connection at the end
    mysqli_close($conn);
    ?>
</body>

</html>