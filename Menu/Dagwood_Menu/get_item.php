<?php
// get_item.php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include '../../db_connect.php'; // Adjust the path to your db_connect.php

// Check if 'id' is set in the query parameters
if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // Ensure it's an integer to prevent SQL injection

    // Prepare the SQL statement
    $stmt = $conn->prepare("SELECT description, price FROM dagwood WHERE id = ?");
    $stmt->bind_param("i", $id); // Bind the parameter

    // Execute the statement
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            // Fetch the item details
            $item = $result->fetch_assoc();
            echo json_encode([
                "status" => "success",
                "description" => $item['description'],
                "price" => $item['price']
            ]);
        } else {
            // Item not found
            echo json_encode([
                "status" => "error",
                "message" => "Item not found."
            ]);
        }
    } else {
        echo json_encode([
            "status" => "error",
            "message" => "Database query failed."
        ]);
    }
    
    $stmt->close();
} else {
    echo json_encode([
        "status" => "error",
        "message" => "No ID provided."
    ]);
}

$conn->close(); // Close the database connection
?>
