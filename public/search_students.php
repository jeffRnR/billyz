<?php
include '../includes/db_connect.php';

$search = $_GET['search'];
$search = htmlspecialchars($search, ENT_QUOTES, 'UTF-8');

$sql = "SELECT * FROM Students WHERE admission_no LIKE '%$search%' OR first_name LIKE '%$search%' OR last_name LIKE '%$search%'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    echo "<table class='search-results-table'>";
    echo "<tr><th>Admission No</th><th>First Name</th><th>Last Name</th></tr>";
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td><a href='view_student.php?id=" . $row['admission_no'] . "'>" . $row['admission_no'] . "</a></td>";
        echo "<td>" . htmlspecialchars($row['first_name'], ENT_QUOTES, 'UTF-8') . "</td>";
        echo "<td>" . htmlspecialchars($row['last_name'], ENT_QUOTES, 'UTF-8') . "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "No results found.";
}
mysqli_close($conn);
?>