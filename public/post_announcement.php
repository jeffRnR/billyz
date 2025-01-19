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
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Process the form submission
        $posted_by = 1; // This should be the logged-in user's ID
        $title = $_POST['title'];
        $content = $_POST['content'];

        $sql = "INSERT INTO Announcements (title, content, posted_by) VALUES ('$title', '$content', '$posted_by')";

        if (mysqli_query($conn, $sql)) {
            echo "<div class='message success'>Announcement posted successfully!</div>";
        } else {
            echo "<div class='message error'>Error: " . $sql . "<br>" . mysqli_error($conn) . "</div>";
        }

        mysqli_close($conn);
    } else {
        // Display the form
        ?>
        <div class="form-container">
            <h2>Post New Announcement</h2>
            <form action="post_announcement.php" method="POST">
                <label for="title">Title:</label>
                <input type="text" id="title" name="title" required>

                <label for="content">Content:</label>
                <textarea id="content" name="content" required></textarea>

                <button type="submit">Post Announcement</button>
            </form>
        </div>
        <?php
    }
    ?>

    <?php include '../includes/footer.php'; ?>
</body>

</html>