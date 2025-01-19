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
    $announcement_id = $_GET['id'];

    $sql = "SELECT * FROM Announcements WHERE announcement_id=$announcement_id";
    $result = mysqli_query($conn, $sql);

    if ($row = mysqli_fetch_assoc($result)) {
        echo "<div class='announcement-details'>";
        echo "<h2>Announcement Details</h2>";
        echo "<p><strong>Title:</strong> " . htmlspecialchars($row['title'], ENT_QUOTES, 'UTF-8') . "</p>";
        echo "<p><strong>Content:</strong> " . nl2br(htmlspecialchars($row['content'], ENT_QUOTES, 'UTF-8')) . "</p>";
        echo "<p><strong>Posted By:</strong> " . htmlspecialchars($row['posted_by'], ENT_QUOTES, 'UTF-8') . "</p>";
        echo "<p><strong>Posted At:</strong> " . htmlspecialchars($row['posted_at'], ENT_QUOTES, 'UTF-8') . "</p>";
        echo "</div>";
    } else {
        echo "<div class='message error'>Announcement not found.</div>";
    }

    mysqli_close($conn);
    ?>

    <?php include '../includes/footer.php'; ?>
</body>

</html>