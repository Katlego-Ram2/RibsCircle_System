<?php
include 'db_connect.php';

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['name'], $_POST['email'], $_POST['phone'], $_POST['userId'])) {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $userId = $_POST['userId'];

        // Debug: Log the received data
        error_log("Received data: name=$name, email=$email, phone=$phone, userId=$userId");

        $sql = "UPDATE users SET username = ?, email = ?, phone = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        if ($stmt) {
            $stmt->bind_param('sssi', $name, $email, $phone, $userId);
            if ($stmt->execute()) {
                echo json_encode(['status' => 'success', 'message' => 'Profile updated successfully.']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Failed to update profile.']);
            }
            $stmt->close();
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to prepare statement: ' . $conn->error]);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Invalid input.']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
}

$conn->close();
?>
