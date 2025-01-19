<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
include '../includes/db_connect.php';

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

function is_admin_or_developer($role_id)
{
    return $role_id == 5 || $role_id == 6; // Assuming 5 is Admin and 6 is Developer
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['role_id']) && is_admin_or_developer($_SESSION['role_id'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $role_id = mysqli_real_escape_string($conn, $_POST['role_id']);

    // Hash the password before storing it
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insert the user data into the database
    $sql = "INSERT INTO users (username, email, password, role_id) VALUES ('$username', '$email', '$hashed_password', '$role_id')";

    if (mysqli_query($conn, $sql)) {
        echo "<script>
                alert('User registered successfully!');
                window.location.href = 'dashboard.php'; // Redirect to dashboard after successful registration
              </script>";
    } else {
        echo "<script>
                alert('Error: " . mysqli_error($conn) . " - " . $sql . "');
              </script>";
    }

    mysqli_close($conn);
} else if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $error = "Only Admins and Developers can register new users.";
    echo "<script>
            alert('" . $error . "');
          </script>";
}

// Fetch roles from the database
$roles_sql = "SELECT * FROM Roles";
$roles_result = mysqli_query($conn, $roles_sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Staff Registration</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color: #333;
            text-align: center;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            margin-top: 10px;
            margin-bottom: 5px;
            font-weight: bold;
        }

        input,
        select {
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        input[type="submit"] {
            background-color: #28a745;
            color: #fff;
            border: none;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #218838;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>User Registration</h1>
        <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required><br><br>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required><br><br>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required><br><br>
            <label for="role_id">Role:</label>
            <select id="role_id" name="role_id" required>
                <option value="5">Admin</option>
                <option value="6">Developer</option>
            </select><br><br>
            <input type="submit" value="Register">
        </form>
    </div>
</body>

</html>