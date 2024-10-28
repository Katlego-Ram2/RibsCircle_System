<?php
// register.php
include '../db_connect.php';

$errors = [];
$successMessage = '';
$username = $email = $password = $confirmPassword = $phone = $preferredContact = '';
$borderClass = [
    'username' => '',
    'email' => '',
    'password' => '',
    'confirmPassword' => '',
    'phone' => '',
    'preferredContact' => ''
];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];
    $phone = trim($_POST['phone']);
    $preferredContact = trim($_POST['preferredContact']);

    // Validation
    if (empty($username) || strlen($username) < 3) {
        $errors['username'] = "Username must be at least 3 characters long.";
        $borderClass['username'] = 'error';
    }

    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Please enter a valid email address.";
        $borderClass['email'] = 'error';
    }

    if (empty($password) || strlen($password) < 6) {
        $errors['password'] = "Password must be at least 6 characters long.";
        $borderClass['password'] = 'error';
    }

    if ($password !== $confirmPassword) {
        $errors['confirmPassword'] = "Passwords do not match.";
        $borderClass['confirmPassword'] = 'error';
    }

    if (!empty($phone) && !preg_match("/^[0-9]{10}$/", $phone)) {
        $errors['phone'] = "Please enter a valid 10-digit phone number.";
        $borderClass['phone'] = 'error';
    }

    if (empty($preferredContact)) {
        $errors['preferredContact'] = "Please select a preferred method of communication.";
        $borderClass['preferredContact'] = 'error';
    }

    // Check if username or email already exists
    $stmt = $conn->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
    $stmt->bind_param("ss", $username, $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $errors['username'] = "Username or email already exists.";
        $borderClass['username'] = 'error';
        $borderClass['email'] = 'error';
    }

    $stmt->close();

    // If there are no errors, proceed with registration
    if (empty($errors)) {
        // Hash the password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Prepare and bind
        $stmt = $conn->prepare("INSERT INTO users (username, email, password, phone, preferred_contact) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $username, $email, $hashed_password, $phone, $preferredContact);

        // Execute and check for success
        if ($stmt->execute()) {
            $successMessage = "Registration successful! You can now log in.";
            header("Location: ../login/login.php");
            exit(); // Ensure script execution stops after redirect
        } else {
            $errors['general'] = "Error: " . $stmt->error;
        }

        $stmt->close();
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="./register.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
    .logo {
        max-width: 100px;
        /* Adjust the size as needed */
        margin-bottom: 20px;
        /* Space below the logo */
    }

    .header {
        display: flex;
        align-items: center;
        margin-bottom: 20px;
        /* Space below the header */
    }

    .message {
        margin-bottom: 20px;
    }

    .already-registered {
        margin-top: 20px;
    }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <img src="./../assets/images/Logo.png" alt="Logo" class="logo"> <!-- Change the path to your logo -->
            <h2>Register</h2>
        </div>

        <?php if (!empty($errors) || !empty($successMessage)): ?>
        <div class="message">
            <?php if (!empty($successMessage)): ?>
            <div class="success-message"><?php echo $successMessage; ?></div>
            <?php endif; ?>
            <?php if (!empty($errors)): ?>
            <ul>
                <?php foreach ($errors as $error): ?>
                <li class="error-message"><?php echo $error; ?></li>
                <?php endforeach; ?>
            </ul>
            <?php endif; ?>
        </div>
        <?php endif; ?>

        <form action="register.php" method="post">
            <label for="username">Username:</label>
            <input type="text" name="username" value="<?php echo htmlspecialchars($username); ?>"
                class="<?php echo $borderClass['username']; ?>" required>

            <label for="email">Email:</label>
            <input type="email" name="email" value="<?php echo htmlspecialchars($email); ?>"
                class="<?php echo $borderClass['email']; ?>" required>

            <label for="password">Password:</label>
            <input type="password" name="password" class="<?php echo $borderClass['password']; ?>" required>

            <label for="confirmPassword">Confirm Password:</label>
            <input type="password" name="confirmPassword" class="<?php echo $borderClass['confirmPassword']; ?>"
                required>

            <label for="phone">Phone Number:</label>
            <input type="text" name="phone" value="<?php echo htmlspecialchars($phone); ?>"
                class="<?php echo $borderClass['phone']; ?>" required>

            <label for="preferredContact">Preferred Method of Communication:</label>
            <select name="preferredContact" class="<?php echo $borderClass['preferredContact']; ?>" required>
                <option value="">Select a method</option>
                <option value="email" <?php echo ($preferredContact === 'email') ? 'selected' : ''; ?>>Email</option>
                <option value="phone" <?php echo ($preferredContact === 'phone') ? 'selected' : ''; ?>>Phone</option>
                <option value="sms" <?php echo ($preferredContact === 'sms') ? 'selected' : ''; ?>>SMS</option>
            </select>

            <button type="submit">Register</button>
        </form>

        <div class="already-registered">
            <p>Already registered? <a href="../login/login.php">Log in here</a>.</p>
        </div>

        <div class="social-icons">

            <a href="https://www.facebook.com" target="_blank" class="social-icon"><i class="fab fa-facebook-f"></i></a>
            <a href="https://wa.me" target="_blank" class="social-icon"><i class="fab fa-whatsapp"></i></a>
            <a href="mailto:youremail@example.com" class="social-icon"><i class="fas fa-envelope"></i></a>
            <a href="https://www.tiktok.com" target="_blank" class="social-icon"><i class="fab fa-tiktok"></i></a>
        </div>
    </div>
</body>

</html>