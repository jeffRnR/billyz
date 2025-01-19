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
    $message_id = $_GET['id'];

    $sql = "SELECT * FROM Messages WHERE message_id=$message_id";
    $result = mysqli_query($conn, $sql);

    if ($row = mysqli_fetch_assoc($result)) {
        echo "<div class='message-details'>";
        echo "<h2>Message Details</h2>";
        echo "<p><strong>Sender ID:</strong> " . htmlspecialchars($row['sender_id'], ENT_QUOTES, 'UTF-8') . "</p>";
        echo "<p><strong>Receiver ID:</strong> " . htmlspecialchars($row['receiver_id'], ENT_QUOTES, 'UTF-8') . "</p>";
        echo "<p><strong>Subject:</strong> " . htmlspecialchars($row['subject'], ENT_QUOTES, 'UTF-8') . "</p>";
        echo "<p><strong>Sent At:</strong> " . htmlspecialchars($row['sent_at'], ENT_QUOTES, 'UTF-8') . "</p>";
        echo "<p><strong>Message Body:</strong> " . nl2br(htmlspecialchars($row['message_body'], ENT_QUOTES, 'UTF-8')) . "</p>";
        echo "</div>";
    } else {
        echo "<div class='message error'>Message not found.</div>";
    }

    mysqli_close($conn);
    ?>

    <?php include '../includes/footer.php'; ?>
</body>

</html>