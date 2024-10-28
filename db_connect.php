<?php
// db_connect.php

// Database configuration
$host = 'localhost';
$username = 'root'; // Default XAMPP username
$password = '';     // Default XAMPP password (empty by default)
$database = 'ribs_circle'; // Your database name

// Create connection
$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}