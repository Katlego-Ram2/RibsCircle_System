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
            $description = $_POST['description'];
            $price = $_POST['price'];
            $image = $_FILES['image']['name'];
            $target = "../uploads/" . basename($image);
            move_uploaded_file($_FILES['image']['tmp_name'], $target);

            $sql = "INSERT INTO chicken (description, price, image) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sds", $description, $price, $image);
            $stmt->execute();
            $stmt->close();
            break;

        case 'delete_chicken_item':
            $id = $_POST['id'];
            $sql = "DELETE FROM chicken WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $stmt->close();
            break;

        case 'add_dagwood_item':
            $description = $_POST['description'];
            $price = $_POST['price'];
            $image = $_FILES['image']['name'];
            $target = "../uploads/" . basename($image);
            move_uploaded_file($_FILES['image']['tmp_name'], $target);

            $sql = "INSERT INTO dagwood (description, price, image) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sds", $description, $price, $image);
            $stmt->execute();
            $stmt->close();
            break;

        case 'delete_dagwood_item':
            $id = $_POST['id'];
            $sql = "DELETE FROM dagwood WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $stmt->close();
            break;

        case 'add_ribs_item':
            $description = $_POST['description'];
            $price = $_POST['price'];
            $image = $_FILES['image']['name'];
            $target = "../uploads/" . basename($image);
            move_uploaded_file($_FILES['image']['tmp_name'], $target);

            $sql = "INSERT INTO ribs (description, price, image) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sds", $description, $price, $image);
            $stmt->execute();
            $stmt->close();
            break;

        case 'delete_ribs_item':
            $id = $_POST['id'];
            $sql = "DELETE FROM ribs WHERE id = ?";
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
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="admin.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f4f4f4;
        }

        h1, h2 {
            color: #333;
            text-align: center;
            margin-bottom: 20px;
        }

        form {
            margin-bottom: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        input[type="text"],
        input[type="number"],
        input[type="password"],
        input[type="email"],
        select {
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            width: 80%;
            max-width: 400px;
        }

        button {
            padding: 10px 20px;
            background-color: #333;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #555;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        table, th, td {
            border: 1px solid #ccc;
        }

        th, td {
            padding: 15px;
            text-align: left;
        }

        th {
            background-color: #f4f4f4;
        }

        td form {
            display: inline;
        }

        td button {
            margin: 0;
            padding: 5px 10px;
            font-size: 14px;
        }

        img {
            width: 100px;
            height: auto;
        }
    </style>
</head>

<body>
    <h1>Admin Dashboard</h1>

    <h2>Manage Chicken Products</h2>
    <form method="post" enctype="multipart/form-data">
        <input type="hidden" name="action" value="add_chicken_item">
        <input type="text" name="description" placeholder="Description" required>
        <input type="number" step="0.01" name="price" placeholder="Price" required>
        <input type="file" name="image" accept="image/*" required>
        <button type="submit">Add Chicken Item</button>
    </form>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Description</th>
                <th>Price</th>
                <th>Image</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($chicken_items as $item): ?>
            <tr>
                <td><?php echo $item['id']; ?></td>
                <td><?php echo $item['description']; ?></td>
                <td><?php echo $item['price']; ?></td>
                <td>
                    <?php if ($item['image']): ?>
                        <img src="../uploads/<?php echo $item['image']; ?>" alt="<?php echo $item['description']; ?>">
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

    <h2>Manage Dagwood Products</h2>
    <form method="post" enctype="multipart/form-data">
        <input type="hidden" name="action" value="add_dagwood_item">
        <input type="text" name="description" placeholder="Description" required>
        <input type="number" step="0.01" name="price" placeholder="Price" required>
        <input type="file" name="image" accept="image/*" required>
        <button type="submit">Add Dagwood Item</button>
    </form>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Description</th>
                <th>Price</th>
                <th>Image</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($dagwood_items as $item): ?>
            <tr>
                <td><?php echo $item['id']; ?></td>
                <td><?php echo $item['description']; ?></td>
                <td><?php echo $item['price']; ?></td>
                <td>
                    <?php if ($item['image']): ?>
                        <img src="../uploads/<?php echo $item['image']; ?>" alt="<?php echo $item['description']; ?>">
                    <?php endif; ?>
                </td>
                <td>
                    <form method="post" style="display:inline;">
                        <input type="hidden" name="action" value="delete_dagwood_item">
                        <input type="hidden" name="id" value="<?php echo $item['id']; ?>">
                        <button type="submit">Delete</button>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <h2>Manage Ribs Products</h2>
    <form method="post" enctype="multipart/form-data">
        <input type="hidden" name="action" value="add_ribs_item">
        <input type="text" name="description" placeholder="Description" required>
        <input type="number" step="0.01" name="price" placeholder="Price" required>
        <input type="file" name="image" accept="image/*" required>
        <button type="submit">Add Ribs Item</button>
    </form>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Description</th>
                <th>Price</th>
                <th>Image</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($ribs_items as $item): ?>
            <tr>
                <td><?php echo $item['id']; ?></td>
                <td><?php echo $item['description']; ?></td>
                <td><?php echo $item['price']; ?></td>
                <td>
                    <?php if ($item['image']): ?>
                        <img src="../uploads/<?php echo $item['image']; ?>" alt="<?php echo $item['description']; ?>">
                    <?php endif; ?>
                </td>
                <td>
                    <form method="post" style="display:inline;">
                        <input type="hidden" name="action" value="delete_ribs_item">
                        <input type="hidden" name="id" value="<?php echo $item['id']; ?>">
                        <button type="submit">Delete</button>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <h2>Manage Users</h2>
    <form method="post">
        <input type="hidden" name="action" value="add_user">
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="text" name="phone" placeholder="Phone">
        <select name="preferred_contact" required>
            <option value="email">Email</option>
            <option value="phone">Phone</option>
            <option value="sms">SMS</option>
        </select>
        <button type="submit">Add User</button>
    </form>
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
                <td><?php echo $user['username']; ?></td>
                <td><?php echo $user['email']; ?></td>
                <td><?php echo $user['phone']; ?></td>
                <td><?php echo $user['preferred_contact']; ?></td>
                <td><?php echo $user['role']; ?></td> 
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
<!-- report -->
    <h2>Generate Daily Sales Report</h2>
    <form method="post">
        <input type="hidden" name="action" value="generate_report">
        <button type="submit">Download Today's Report</button>
    </form>

</body>

</html>
