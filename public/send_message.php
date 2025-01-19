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
        $sender_id = 1; // This should be the logged-in user's ID
        $receiver_id = $_POST['receiver_id'];
        $subject = $_POST['subject'];
        $message_body = $_POST['message_body'];

        $sql = "INSERT INTO Messages (sender_id, receiver_id, subject, message_body) VALUES ('$sender_id', '$receiver_id', '$subject', '$message_body')";

        if (mysqli_query($conn, $sql)) {
            echo "<div class='message success'>Message sent successfully!</div>";
        } else {
            echo "<div class='message error'>Error: " . $sql . "<br>" . mysqli_error($conn) . "</div>";
        }

        mysqli_close($conn);
    } else {
        // Display the form
        ?>
        <div class="form-container">
            <h2>Send New Message</h2>
            <form action="send_message.php" method="POST">
                <label for="receiver_id">Receiver ID:</label>
                <input type="number" id="receiver_id" name="receiver_id" required>

                <label for="subject">Subject:</label>
                <input type="text" id="subject" name="subject" required>

                <label for="message_body">Message Body:</label>
                <textarea id="message_body" name="message_body" required></textarea>

                <button type="submit">Send Message</button>
            </form>
        </div>
        <?php
    }
    ?>

    <?php include '../includes/footer.php'; ?>
</body>

</html>