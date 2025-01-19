<!DOCTYPE html>
<html>

<head>
    <title>College Management System</title>
    <link rel="stylesheet" type="text/css" href="../assets/css/style.css">
</head>

<body>
    <?php include '../includes/header.php'; ?>
    <?php include '../includes/db_connect.php'; ?>

    <?php
    $user_id = 1; // This should be the logged-in user's ID
    
    $sql = "SELECT * FROM Messages WHERE receiver_id=$user_id";
    $result = mysqli_query($conn, $sql);

    echo "<h2>Received Messages</h2>";
    echo "<table class='messages-table'>";
    echo "<tr><th>Message ID</th><th>Sender ID</th><th>Subject</th><th>Received At</th><th>Details</th></tr>";

    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . $row['message_id'] . "</td>";
        echo "<td>" . htmlspecialchars($row['sender_id'], ENT_QUOTES, 'UTF-8') . "</td>";
        echo "<td>" . htmlspecialchars($row['subject'], ENT_QUOTES, 'UTF-8') . "</td>";
        echo "<td>" . htmlspecialchars($row['sent_at'], ENT_QUOTES, 'UTF-8') . "</td>";
        echo "<td><a href='view_message.php?id=" . $row['message_id'] . "'>View</a></td>";
        echo "</tr>";
    }

    echo "</table>";
    mysqli_close($conn);
    ?>

    <?php include '../includes/footer.php'; ?>
</body>

</html>