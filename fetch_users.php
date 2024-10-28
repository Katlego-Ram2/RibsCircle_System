<?php
include 'db_connect.php';

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

$sql = "SELECT COUNT(*) as user_count FROM users";
$result = $conn->query($sql);

$data = [];
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $data[] = $row;
}

echo json_encode($data);
$conn->close();
?>
