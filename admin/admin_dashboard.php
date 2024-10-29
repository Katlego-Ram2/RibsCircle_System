<?php
session_start();
if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
    header("Location: /admin/AdminLogin.php");
    exit();
}

include '../db_connect.php';

// Handle form submissions for menu items
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action'])) {
    switch ($_POST['action']) {
        case 'add_chicken_item':
        case 'add_dagwood_item':
        case 'add_ribs_item':
            $description = $_POST['description'];
            $price = $_POST['price'];
            $image = $_FILES['image']['name'];
            $target = "../uploads/" . basename($image);
            move_uploaded_file($_FILES['image']['tmp_name'], $target);

            $table = $_POST['action'] === 'add_chicken_item' ? 'chicken' : ($_POST['action'] === 'add_dagwood_item' ? 'dagwood' : 'ribs');
            $sql = "INSERT INTO $table (description, price, image) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sds", $description, $price, $image);
            $stmt->execute();
            $stmt->close();
            break;

        case 'delete_chicken_item':
        case 'delete_dagwood_item':
        case 'delete_ribs_item':
            $id = $_POST['id'];
            $table = $_POST['action'] === 'delete_chicken_item' ? 'chicken' : ($_POST['action'] === 'delete_dagwood_item' ? 'dagwood' : 'ribs');
            $sql = "DELETE FROM $table WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $stmt->close();
            break;

        case 'add_user':
            $username = $_POST['username'];
            $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
            $email = $_POST['email'];
            $phone = $_POST['phone'];
            $preferred_contact = $_POST['preferred_contact'];
            $sql = "INSERT INTO users (username, password, email, phone, preferred_contact) VALUES (?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sssss", $username, $password, $email, $phone, $preferred_contact);
            $stmt->execute();
            $stmt->close();
            break;

        case 'delete_user':
            $id = $_POST['id'];
            $sql = "DELETE FROM users WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $stmt->close();
            break;
    }
}

// Fetch menu items
$chicken_items = $conn->query("SELECT * FROM chicken")->fetch_all(MYSQLI_ASSOC);
$dagwood_items = $conn->query("SELECT * FROM dagwood")->fetch_all(MYSQLI_ASSOC);
$ribs_items = $conn->query("SELECT * FROM ribs")->fetch_all(MYSQLI_ASSOC);

// Fetch users
$users = $conn->query("SELECT * FROM users")->fetch_all(MYSQLI_ASSOC);

$conn->close();

// Pass the data to the HTML file
include 'admin.php';
?>
