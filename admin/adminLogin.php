<?php
session_start();
include '../db_connect.php';

$errors = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM admins WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $admin = $result->fetch_assoc();
        if (password_verify($password, $admin['password'])) {
            $_SESSION['admin'] = true;
            header("Location: index.php");
            exit();
        } else {
            $errors[] = "Invalid password.";
        }
    } else {
        $errors[] = "No admin found with that username.";
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Admin Login</title>
    <style>
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 20px;
        background-color: #f4f4f4;
        display: flex;
        flex-direction: column;
        gap: .75rem;
        justify-content: center;
        align-items: center;
        height: 100vh;
    }

    h1 {
        color: #333;
        text-align: center;
        margin-bottom: 20px;
    }

    form {
        background-color: #fff;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        width: 100%;
        max-width: 400px;
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    input[type="text"],
    input[type="password"] {
        padding: 10px;
        margin: 10px 0;
        border: 1px solid #ccc;
        border-radius: 5px;
        width: 100%;
    }

    button {
        padding: 10px 20px;
        background-color: #333;
        color: #fff;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s ease;
        width: 100%;
    }

    button:hover {
        background-color: #555;
    }

    .error-message {
        color: red;
        text-align: center;
        margin-bottom: 10px;
    }
    </style>
</head>

<body>
    <h1>Admin Login</h1>
    <?php if (!empty($errors)): ?>
    <ul>
        <?php foreach ($errors as $error): ?>
        <li class="error-message"><?php echo $error; ?></li>
        <?php endforeach; ?>
    </ul>
    <?php endif; ?>
    <form action="adminLogin.php" method="post">
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Login</button>
    </form>
</body>

</html>