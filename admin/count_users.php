<?php
include '../db_connect.php';

// Query to count the number of users
$result = $conn->query("SELECT COUNT(*) AS user_count FROM users");
$row = $result->fetch_assoc();
$conn->close();

// Return the user count
echo $row['user_count'];
?>
