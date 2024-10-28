<?php
// Start the session
ob_start();
session_start();

// Check if username is set in the session
$username = '';
if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
}

// If the username is not set, redirect to login page
if (empty($username)) {
    header("Location: /RibsCircle_System/login/login.php"); // Redirect to the correct login path
    exit(); // Ensure no further code is executed
}

$menuItems = [
    'Home' => '/RibsCircle_System/index.php',
    'Gallery' => 'gallery.php',
    'Menu' => [
        'Dagwood Menu' => '/RibsCircle_System/Menu/Dagwood_Menu/dagwood_menu.php',
        'Chicken Menu' => '/RibsCircle_System/Menu/Chicken_Menu/chickenmenu.php',
        'Ribs Menu' => '/RibsCircle_System/Menu/Ribs_Menu/Ribs.php'
    ]
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
        }
        nav {
            background-color: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 20px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        .logo img {
            height: 50px;
        }
        ul {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
            align-items: center;
        }
        ul li {
            position: relative;
            margin-right: 20px;
        }
        ul li a {
            text-decoration: none;
            color: #333;
            padding: 10px;
            transition: color 0.3s;
        }
        ul li a:hover {
            color: orange;
        }
        .menu-dropdown {
            cursor: pointer;
        }
        .dropdown {
            display: none;
            position: absolute;
            background-color: white;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
            min-width: 150px;
            z-index: 1;
            border-radius: 5px;
            margin-top: 5px;
        }
        .dropdown a {
            display: block;
            padding: 10px 15px;
            color: #333;
            text-decoration: none;
            transition: background-color 0.3s;
        }
        .dropdown a:hover {
            background-color: #f0f0f0;
        }
        .sign-in {
            display: flex;
            align-items: center;
        }
        #cart-count {
            margin-left: 5px;
            font-weight: bold;
        }
        .active .dropdown {
            display: block;
        }
    </style>
</head>
<body>
<nav>
    <div class="logo">
        <img src="/RibsCircle_System/Logo.png" alt="Logo">
    </div>
    <ul>
        <?php foreach ($menuItems as $key => $value): ?>
            <?php if (is_array($value)): ?>
                <li class="menu-dropdown">
                    <a><?php echo $key; ?></a>
                    <div class="dropdown">
                        <?php foreach ($value as $subKey => $subValue): ?>
                            <a href="<?php echo $subValue; ?>"><?php echo $subKey; ?></a>
                        <?php endforeach; ?>
                    </div>
                </li>
            <?php else: ?>
                <li><a href="<?php echo $value; ?>"><?php echo $key; ?></a></li>
            <?php endif; ?>
        <?php endforeach; ?>
    </ul>
    <ul style="display: flex; align-items: center; height: 100%;">
        <li>
            <a href="/RibsCircle_System/Cart/cart.php">
                <i class="fas fa-shopping-cart"></i>
                <span id="cart-count" style="color: orange;">0</span>
            </a>
        </li>
        <li class="sign-in">
            <li class="menu-dropdown">
                <a id="user-name"><?php echo htmlspecialchars($username); ?></a> <!-- Set username -->
                <div class="dropdown">
                    <a href="/RibsCircle_System/edit_profile.php">Edit Profile</a>
                    <a href="/RibsCircle_System/login/login.php" id="logout">Logout</a>
                </div>
            </li>
        </li>
    </ul>
</nav>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Set username from local storage
        const username = localStorage.getItem('username');
        const userNameElement = document.getElementById('user-name');
        
        if (userNameElement && username) {
            userNameElement.textContent = username;
        } else {
            window.location.href = '/RibsCircle_System/login/login.php';
        }

        // Set cart count from local storage
        const cartCountElement = document.getElementById('cart-count');
        const cartItems = JSON.parse(localStorage.getItem('cartItems')) || [];
        cartCountElement.textContent = cartItems.length;

        // Handle dropdown menu click
        document.querySelectorAll('.menu-dropdown > a').forEach(menu => {
            menu.addEventListener('click', function (e) {
                e.preventDefault();
                this.parentElement.classList.toggle('active');
            });
        });

        // Close dropdown when clicking outside
        document.addEventListener('click', function (e) {
            if (!e.target.closest('.menu-dropdown')) {
                document.querySelectorAll('.menu-dropdown').forEach(menu => {
                    menu.classList.remove('active');
                });
            }
        });

        // Handle logout
        document.getElementById('logout').addEventListener('click', function (e) {
            e.preventDefault();
            localStorage.removeItem('username');
            localStorage.removeItem('userId');
            localStorage.removeItem('cartItems'); // Clear cart items
            window.location.href = '/RibsCircle_System/login/login.php';
        });
    });
</script>

<script>
    // Array to hold selected items
    let selectedItems = JSON.parse(localStorage.getItem('cart')) || [];
    let totalPrice = selectedItems.reduce((sum, item) => sum + (item.price * item.quantity), 0);

    // Function to add item to the order
    function addItemToOrder(id, description, price) {
        // Check if the item already exists in the selectedItems array
        const existingItemIndex = selectedItems.findIndex(item => item.id === id);

        if (existingItemIndex !== -1) {
            // If it exists, increment the quantity
            selectedItems[existingItemIndex].quantity += 1;
        } else {
            // If it doesn't exist, add a new item
            selectedItems.push({
                id,
                description,
                price,
                quantity: 1
            });
        }

        // Update total price
        totalPrice += price;

        // Save updated items to localStorage
        localStorage.setItem('cart', JSON.stringify(selectedItems));

        // Update cart count display
        updateCartCount();

        // Display the updated order details in the console
        displaySelectedItems();
        alert("Item added to the Cart")
    }

    // Function to display selected items and total price
    function displaySelectedItems() {
        console.clear(); // Optional: clear the console for better visibility
        console.log("Selected Items:");

        selectedItems.forEach(item => {
            console.log(
                `- ${item.description} (Quantity: ${item.quantity}): R${(item.price * item.quantity).toFixed(2)}`
            );
        });

        console.log(`Total Price: R${totalPrice.toFixed(2)}`);
    }

    // Function to update the cart count display
    function updateCartCount() {
        const totalCount = selectedItems.reduce((sum, item) => sum + item.quantity, 0);
        document.getElementById('cart-count').innerText = totalCount;
    }

    // Modify fetchItemDetails to call addItemToOrder with the fetched details
    function fetchItemDetails(id) {
        fetch(`get_item.php?id=${id}`)
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    // Call addItemToOrder with the fetched details
                    addItemToOrder(id, data.description, parseFloat(data.price));
                } else {
                    console.error(data.message);
                }
            })
            .catch(error => {
                console.error('Error fetching item details:', error);
            });
    }

    // On page load, update the cart count and display existing selected items
    window.onload = () => {
        updateCartCount();
        displaySelectedItems();
    };

    // Function to perform the search and redirect to the item
    function performSearch() {
        const searchInput = document.getElementById('search-input').value.trim().toLowerCase();

        // Mapping item names to their URLs or IDs
        const itemsMap = {
            'ham & cheese dagwood': './dagwood_details.php?id=1',
            'chicken mayo dagwood': './dagwood_details.php?id=2',
            'beef/chicken dagwood': './dagwood_details.php?id=3',
            'beef & egg dagwood': './dagwood_details.php?id=4',
            'beef & cheese dagwood': './dagwood_details.php?id=5',
            'bacon & ham dagwood': './dagwood_details.php?id=6',
            'dagwood with ribs': './dagwood_details.php?id=7',
            // Add more items as necessary
            // Example: 'item name': 'link'
        };

        // Find the matching item
        const itemUrl = itemsMap[searchInput];

        if (itemUrl) {
            // Redirect to the item's page
            window.location.href = itemUrl;
        } else {
            alert('Item not found. Please try another search.');
        }
    }
    </script>
</body>
</html>
