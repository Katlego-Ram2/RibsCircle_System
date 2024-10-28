<?php
// book_reservation.php

// Database connection settings
$host = 'localhost'; // Your database host
$db = 'ribs_circle'; // Your database name
$user = 'root'; // Your database username
$pass = ''; // Your database password

// Create a connection
$conn = new mysqli($host, $user, $pass, $db);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the posted data
$name = $_POST['name'];
$phone = $_POST['phone'];
$date = $_POST['date'];
$time = $_POST['time'];
$guests = $_POST['guests'];

// Insert into the database
$sql = "INSERT INTO reservations (name, phone, date, time, guests) VALUES ('$name', '$phone', '$date', '$time', '$guests')";
if ($conn->query($sql) === TRUE) {
    // Prepare the WhatsApp message
    $whatsappMessage = "New reservation:\nName: $name\nPhone: $phone\nDate: $date\nTime: $time\nGuests: $guests";
    
    // URL for WhatsApp message
    $whatsappNumber = "YOUR_WHATSAPP_NUMBER"; // Replace with the business WhatsApp number
    $whatsappURL = "https://wa.me/+27812185717?text=" . urlencode($whatsappMessage);

    // Return success with the WhatsApp link
    echo json_encode([
        'status' => 'success',
        'message' => 'Booked successfully!',
        'whatsapp_url' => $whatsappURL // Send WhatsApp URL to the front-end
    ]);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Error: ' . $conn->error]);
}

$conn->close();

