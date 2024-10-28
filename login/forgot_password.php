<?php
// forgot_password.php
include '../db_connect.php'; // Include your database connection
$errors = [];
$email = '';
$successMessage = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['email']);

    // Validation
    if (empty($email)) {
        $errors['email'] = "Please enter your email address.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Please enter a valid email address.";
    }

    // If no errors, check the database for the email
    if (empty($errors)) {
        $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows === 1) {
            // Here you would typically send the reset link
            // Example of sending a reset link (pseudo-code):
            // mail($email, "Password Reset", "Click here to reset your password...");

            // Simulate a success message
            $successMessage = "A reset link has been sent to your email.";
        } else {
            $errors['email'] = "No account found with that email address.";
        }

        $stmt->close();
    }
}

$conn->close(); // Close the database connection
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <link rel="stylesheet" href="logStyle.css">
    <style>
        .error-message {
            color: red;
            margin-top: 5px;
        }
        .success-message {
            color: green;
            margin-top: 5px;
        }
        .logo {
            max-width: 100px; /* Adjust size as needed */
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <img src="../assets/images/Logo.png" alt="Logo" class="logo"> <!-- Add your logo here -->
        <h2>Forgot Password</h2>
        
        <?php if (!empty($errors)): ?>
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li class="error-message"><?php echo $error; ?></li>
                <?php endforeach; ?>
            </ul>
        <?php elseif (!empty($successMessage)): ?>
            <div class="success-message"><?php echo $successMessage; ?></div>
        <?php endif; ?>

        <form action="forgot_password.php" method="post">
            <label for="email">Enter your email address:</label>
            <input type="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required>
            <button type="submit">Send Reset Link</button>
        </form>
        
        <div class="back-to-login">
            <a href="login.php">Back to Login</a>
        </div>
    </div>
</body>
</html>
