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
    $sql = "SELECT * FROM Announcements";
    $result = mysqli_query($conn, $sql);

    echo "<h2>Announcements</h2>";
    echo "<table class='announcements-table'>";
    echo "<tr><th>Announcement ID</th><th>Title</th><th>Posted By</th><th>Posted At</th><th>Details</th></tr>";

    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . $row['announcement_id'] . "</td>";
        echo "<td>" . htmlspecialchars($row['title'], ENT_QUOTES, 'UTF-8') . "</td>";
        echo "<td>" . htmlspecialchars($row['posted_by'], ENT_QUOTES, 'UTF-8') . "</td>";
        echo "<td>" . htmlspecialchars($row['posted_at'], ENT_QUOTES, 'UTF-8') . "</td>";
        echo "<td><a href='view_announcement.php?id=" . $row['announcement_id'] . "'>View</a></td>";
        echo "</tr>";
    }

    echo "</table>";
    mysqli_close($conn);
    ?>

    <?php include '../includes/footer.php'; ?>
</body>

</html>