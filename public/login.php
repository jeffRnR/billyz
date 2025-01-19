<?php
session_start();
include '../includes/db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $role_id = mysqli_real_escape_string($conn, $_POST['role_id']);

    // Fetch user data from the database
    $sql = "SELECT * FROM Users WHERE username='$username'";
    $result = mysqli_query($conn, $sql);

    if ($row = mysqli_fetch_assoc($result)) {
        // Verify the password
        if (password_verify($password, $row['password'])) {
            // Password is correct, start the session
            $_SESSION['username'] = $username;
            $_SESSION['role_id'] = $row['role_id']; // Store role_id from database
            header("Location: developer_dashboard.php");
            exit();
        } else {
            // Invalid password
            $error = "Invalid username or password.";
        }
    } else {
        // Invalid username
        $error = "Invalid username or password.";
    }
}

// Fetch roles from the database
$roles_sql = "SELECT * FROM Roles";
$roles_result = mysqli_query($conn, $roles_sql);
?>
<!DOCTYPE html>
<html>

<head>
    <title>College Management System</title>
    <link rel="stylesheet" type="text/css" href="../assets/css/style.css">
</head>

<body>
    <?php include '../includes/header.php'; ?>

    <div class="login-container">
        <h2>Login</h2>
        <form action="login.php" method="POST">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>

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

            <button type="submit">Login</button>
        </form>
        <?php
        if (isset($error)) {
            echo "<div class='message error'>$error</div>";
        }
        ?>
    </div>

    <?php include '../includes/footer.php'; ?>

    <?php
    // Close the database connection at the end
    mysqli_close($conn);
    ?>
</body>

</html>