<?php
include '../db_connect.php';

// Function to handle file uploads
function uploadFile($file) {
    $target_dir = "../uploads/";
    $target_file = $target_dir . basename($file["name"]);
    if (move_uploaded_file($file["tmp_name"], $target_file)) {
        return $file["name"];
    }
    return null; // or handle error
}

// Handle form submissions for menu items and user updates
// ... [existing handling code]

$chicken_items_per_page = 10; // Items per page for chicken
$current_chicken_page = isset($_GET['chicken_page']) ? (int)$_GET['chicken_page'] : 1;
$chicken_offset = ($current_chicken_page - 1) * $chicken_items_per_page;

// Fetch paginated chicken items
$chicken_items = $conn->query("SELECT * FROM chicken LIMIT $chicken_items_per_page OFFSET $chicken_offset")->fetch_all(MYSQLI_ASSOC);
$total_chicken_items = $conn->query("SELECT COUNT(*) AS count FROM chicken")->fetch_assoc()['count'];
$total_chicken_pages = ceil($total_chicken_items / $chicken_items_per_page);

// Fetch paginated users
$users_per_page = 10; // Items per page for users
$current_user_page = isset($_GET['user_page']) ? (int)$_GET['user_page'] : 1;
$user_offset = ($current_user_page - 1) * $users_per_page;

$users = $conn->query("SELECT * FROM users LIMIT $users_per_page OFFSET $user_offset")->fetch_all(MYSQLI_ASSOC);
$total_users = $conn->query("SELECT COUNT(*) AS count FROM users")->fetch_assoc()['count'];
$total_user_pages = ceil($total_users / $users_per_page);

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="admin.css">
    <link href="./vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        img {
            max-width: 100px; /* Set max width for images */
            height: auto; /* Maintain aspect ratio */
        }

        /* Styles for Chicken Products Pagination */
        .pagination-chicken {
            display: flex;
            justify-content: center; /* Center the pagination links */
            margin: 20px 0; /* Add some margin for spacing */
        }
        .pagination-chicken a {
            margin: 0 10px; /* Add more spacing between links */
            padding: 10px 15px; /* Add padding for better clickability */
            background-color: #007bff; /* Bootstrap primary color */
            color: white; /* Text color */
            border-radius: 5px; /* Rounded corners */
            text-decoration: none; /* Remove underline */
            transition: background-color 0.3s; /* Smooth transition for hover */
        }
        .pagination-chicken a:hover {
            background-color: #0056b3; /* Darker blue on hover */
        }
        .pagination-chicken .active {
            background-color: #0056b3; /* Active page styling */
            font-weight: bold; /* Make active link bold */
        }

        /* Styles for Users Pagination */
        .pagination-users {
            display: flex;
            justify-content: center; /* Center the pagination links */
            margin: 20px 0; /* Add some margin for spacing */
        }
        .pagination-users a {
            margin: 0 10px; /* Add more spacing between links */
            padding: 10px 15px; /* Add padding for better clickability */
            background-color: #28a745; /* Green color for users */
            color: white; /* Text color */
            border-radius: 5px; /* Rounded corners */
            text-decoration: none; /* Remove underline */
            transition: background-color 0.3s; /* Smooth transition for hover */
        }
        .pagination-users a:hover {
            background-color: #218838; /* Darker green on hover */
        }
        .pagination-users .active {
            background-color: #218838; /* Active page styling */
            font-weight: bold; /* Make active link bold */
        }
    </style>
</head>
<body>
    <h1>Update User Details And Menu</h1>
    <div>
        <button onclick="window.location.href='http://localhost/RibsCircle_System/admin/report.php#'" style="display: flex; align-items: center;">
            <i class="fas fa-arrow-left" style="margin-right: 8px;"></i>
            Back to Dashboard
        </button>
    </div>

    <!-- Chicken Products -->
    <h2>Manage Chicken Products</h2>
    <form method="post" enctype="multipart/form-data">
        <input type="hidden" name="action" value="add_chicken_item">
        <input type="text" name="description" placeholder="Description" required>
        <input type="number" step="0.01" name="price" placeholder="Price (ZAR)" required>
        <input type="file" name="image" accept="image/*" required><br>
        <button type="submit">Add Chicken Item</button><br>
    </form>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Description</th>
                <th>Price (ZAR)</th>
                <th>Image</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($chicken_items as $item): ?>
            <tr>
                <td><?php echo $item['id']; ?></td>
                <td><?php echo htmlspecialchars($item['description']); ?></td>
                <td><?php echo 'R' . number_format($item['price'], 2); ?></td>
                <td>
                    <?php if ($item['image']): ?>
                        <img src="../uploads/<?php echo htmlspecialchars($item['image']); ?>" alt="<?php echo htmlspecialchars($item['description']); ?>">
                    <?php endif; ?>
                </td>
                <td>
                    <form method="post" style="display:inline;">
                        <input type="hidden" name="action" value="delete_chicken_item">
                        <input type="hidden" name="id" value="<?php echo $item['id']; ?>">
                        <button type="submit">Delete</button>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <!-- Pagination for Chicken Products -->
    <div class="pagination-chicken">
        <?php for ($i = 1; $i <= $total_chicken_pages; $i++): ?>
            <a href="?chicken_page=<?php echo $i; ?>" class="<?php echo $i === $current_chicken_page ? 'active' : ''; ?>">
                <?php echo $i; ?>
            </a>
        <?php endfor; ?>
    </div>

    <h2>Manage Users</h2>
    
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Preferred Contact</th>
                <th>Role</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
            <tr>
                <td><?php echo $user['id']; ?></td>
                <td><?php echo htmlspecialchars($user['username']); ?></td>
                <td><?php echo htmlspecialchars($user['email']); ?></td>
                <td><?php echo htmlspecialchars($user['phone']); ?></td>
                <td>
                    <select class="preferred-contact" data-id="<?php echo $user['id']; ?>">
                        <option value="email" <?php if ($user['preferred_contact'] == 'email') echo 'selected'; ?>>Email</option>
                        <option value="phone" <?php if ($user['preferred_contact'] == 'phone') echo 'selected'; ?>>Phone</option>
                        <option value="sms" <?php if ($user['preferred_contact'] == 'sms') echo 'selected'; ?>>SMS</option>
                    </select>
                </td>
                <td>
                    <select class="user-role" data-id="<?php echo $user['id']; ?>">
                        <option value="admin" <?php if ($user['role'] == 'admin') echo 'selected'; ?>>Admin</option>
                        <option value="auditor" <?php if ($user['role'] == 'auditor') echo 'selected'; ?>>Auditor</option>
                        <option value="customer" <?php if ($user['role'] == 'customer') echo 'selected'; ?>>Customer</option>
                    </select>
                </td>
                <td>
                    <form method="post" style="display:inline;">
                        <input type="hidden" name="action" value="delete_user">
                        <input type="hidden" name="id" value="<?php echo $user['id']; ?>">
                        <button type="submit">Delete</button>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <!-- Pagination for Users -->
    <div class="pagination-users">
        <?php for ($i = 1; $i <= $total_user_pages; $i++): ?>
            <a href="?user_page=<?php echo $i; ?>" class="<?php echo $i === $current_user_page ? 'active' : ''; ?>">
                <?php echo $i; ?>
            </a>
        <?php endfor; ?>
    </div>

    <h2>Generate Daily Sales Report</h2>
    <form method="post">
        <input type="hidden" name="action" value="generate_report">
        <button type="submit">Download Today's Report</button>
    </form>

    <script>
        $(document).ready(function() {
            $('.user-role').change(function() {
                var userId = $(this).data('id');
                var newRole = $(this).val();
                
                $.ajax({
                    type: "POST",
                    url: "", // Current page
                    data: {
                        action: 'change_user_role',
                        id: userId,
                        role: newRole
                    },
                    success: function(response) {
                        var result = JSON.parse(response);
                        if (result.success) {
                            alert("User role updated successfully.");
                        } else {
                            alert("Error updating user role.");
                        }
                    },
                    error: function() {
                        alert("Error updating user role.");
                    }
                });
            });

            $('.preferred-contact').change(function() {
                var userId = $(this).data('id');
                var newContact = $(this).val();
                
                $.ajax({
                    type: "POST",
                    url: "", // Current page
                    data: {
                        action: 'change_user_contact',
                        id: userId,
                        preferred_contact: newContact
                    },
                    success: function(response) {
                        var result = JSON.parse(response);
                        if (result.success) {
                            alert("Preferred contact method updated successfully.");
                        } else {
                            alert("Error updating preferred contact method.");
                        }
                    },
                    error: function() {
                        alert("Error updating preferred contact method.");
                    }
                });
            });
        });
    </script>
</body>
</html>
