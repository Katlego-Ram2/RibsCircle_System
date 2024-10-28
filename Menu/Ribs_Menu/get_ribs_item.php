<?php
// Include database connection
include '../../db_connect.php';

// Set header for JSON response
header('Content-Type: application/json');

// Check if an id was passed in the URL
if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // Ensure the id is an integer to prevent SQL injection

    // Prepare SQL statement
    $sql = "SELECT * FROM ribs WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id); // Bind the parameter
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $item = $result->fetch_assoc(); // Fetch the row as an associative array
        echo json_encode(['status' => 'success', 'id' => $item['id'], 'description' => $item['description'], 'price' => $item['price']]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Item not found']);
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();
} else {
    echo json_encode(['status' => 'error', 'message' => 'No item ID provided']);
}
?>