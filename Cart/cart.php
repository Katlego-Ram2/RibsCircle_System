<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart</title>
    <link rel="stylesheet" href="cart.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* Basic styles for the modal */
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.4);
        }

        .modal-content {
            background-color: #fefefe;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 400px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }

        .hidden {
            display: none;
        }

        label {
            display: block;
            margin-top: 10px;
            font-weight: bold;
        }

        input,
        select {
            width: calc(100% - 20px);
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
            transition: border-color 0.3s;
        }

        input:focus,
        select:focus {
            border-color: #007bff;
            outline: none;
        }

        button {
            background-color: #007bff;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 10px;
            font-size: 16px;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #0056b3;
        }

        .pagination {
            margin-top: 20px;
            text-align: center;
        }

        .pagination button {
            margin: 0 10px;
        }
        /* Your existing styles here */
nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px;
            background: rgba(255, 255, 255, 0.8);
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        nav .logo img {
            width: 114px;
            height: 115px;
        }
        nav ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
            display: flex;
        }
        nav ul li {
            margin: 0 10px;
        }
        nav ul li a {
            display: block;
            color: black;
            font-weight: bold;
            text-align: center;
            padding: 14px 16px;
            text-decoration: none;
            transition: background 0.3s ease;
        }
        nav ul li a:hover {
            background-color: #e27373;
            color: white;
        }
        .menu-dropdown {
            position: relative;
        }
        .menu-dropdown .dropdown {
            display: none;
            position: absolute;
            background-color: #fff;
            box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.2);
            padding: 10px 0;
            z-index: 1;
            min-width: 150px;
            border-radius: 5px;
        }
        .menu-dropdown:hover .dropdown {
            display: block;
        }
        .menu-dropdown .dropdown a {
            display: block;
            padding: 10px 15px;
            text-decoration: none;
            color: black;
            transition: background 0.3s ease;
        }
        .menu-dropdown .dropdown a:hover {
            background-color: #e27373;
            color: white;
        }
        .cart {
    text-align: center;
    background-color: white;
    padding: 20px;
    width: 100%;
    height: fit-content;
    
}
.separator{
    width:100%;
    height:5px;
}

    </style>
</head>

<body>
<nav style="background-color: white;">
    <div class="logo">
        <img src="/RibsCircle_System/assets/images/Logo.png" alt="Logo">
    </div>
    <ul>
        <li><a href="/RibsCircle_System/index.php">Home</a></li>
        <li class="menu-dropdown">
            <a>Menu</a>
            <div class="dropdown">
                <a href="/RibsCircle_System/Menu/Dagwood_Menu/dagwood_menu.php">Dagwood Menu</a>
                <a href="/RibsCircle_System/Menu/Chicken_Menu/chickenmenu.php">Chicken Menu</a>
                <a href="/RibsCircle_System/Menu/Ribs_Menu/Ribs.php">Ribs Menu</a>
            </div>
        </li>
        <li><a href="gallery.php">Gallery</a></li>
        <?php if (empty($username)): ?>
       
        <?php endif; ?>
    </ul>
    <ul style="display: flex; align-items: center; height: 100%;">
        
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
<div class="separator"></div>

    <!-- Cart Table -->
    <div class="cart">
        <table class="cart-table">
            <thead>
                <tr>
                    <th>Item</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <!-- Cart items will be dynamically inserted here -->
            </tbody>
        </table>
        <button id="checkoutBtn">Check Out</button>

        <!-- Pagination Controls -->
        <div class="pagination">
            <button id="prevPage" onclick="changePage(-1)">Previous</button>
            <span id="pageInfo"></span>
            <button id="nextPage" onclick="changePage(1)">Next</button>
        </div>
    </div>

    <!-- Checkout Modal -->
    <div id="checkoutModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <h2>Checkout</h2>
            <form id="paymentForm">
                <label for="name">Name:</label>
                <input type="text" name="name" id="name" >
                <br>
                <label for="email">Email:</label>
                <input type="email" name="email" id="email" >
                <br>
                <label for="paymentMethod">Payment Method:</label>
                <select id="paymentMethod"  onchange="showPaymentFields()">
                    <option value="" disabled selected>Select payment method</option>
                    <option value="creditCard" >Credit Card</option>
                    <option value="paypal">PayPal</option>
                    <option  value="bankTransfer">Bank Transfer</option>
                </select>
                <br>

                <!-- Payment Fields -->
                <div id="creditCardFields" class="hidden">
                    <label for="cardNumber">Card Number:</label>
                    <input type="text" id="creditCard" name="creditCard" pattern="\d{16}" title="Please enter a 16-digit credit card number" maxlength="16" >
                    <br>
                    <label for="expiryDate">Expiry Date:</label>
                    <input type="text" id="expiryDate" placeholder="MM/YY" pattern="^(0[1-9]|1[0-2])\/\d{2}$" title="Please enter a valid expiry date (MM/YY)" >
                    <br>
                    <label for="cvv">CVV:</label>
                    <input type="text" name="cvv" id="cvv"  pattern="\d{3}" title="Please enter a valid 3-digit CVV number">
                </div>

                <div id="paypalFields" class="hidden">
                    <label for="paypalEmail">PayPal Email:</label>
                    <input name="email" type="email" id="paypalEmail" >
                </div>

                <div id="bankTransferFields" class="hidden">
                    <label for="accountNumber">Account Number:</label>
                    <input type="text" name="accountNum" id="accountNumber" >
                    <br>
                    <label for="bankName">Bank Name:</label>
                    <input type="text" name="bankName" id="bankName" >
                </div>

                <?php
                if (isset($_POST['submit'])) {
                    // Retrieve data from the form
                    $userEmail = $_POST['email'];
                    $userName = $_POST['name'];
                    $subjectOwner = "New Payment Received";
                    $subjectUser = "Payment Successful";
                    
                    // Construct email messages
                    $messageOwner = "A new payment has been made by:\n\nName: $userName\nEmail: $userEmail";
                    $messageUser = "Dear $userName,\n\nThank you for your purchase at Ribs Circle! Your payment was successfully processed.";//received by the customer
                    // Owner's email
                    $ownerEmail = "khanyisilemoticoe@gmail.com";
                    
                    // Email headers
                    $headersUser = "From: " . $ownerEmail;
                    $headersOwner = "From: " . $userEmail;
                    
                    // Send emails
                    $resultOwner = mail($ownerEmail, $subjectOwner, $messageOwner, $headersOwner);
                    $resultUser = mail($userEmail, $subjectUser, $messageUser, $headersUser);
                    
                    // Check if emails were sent successfully
                    if ($resultOwner && $resultUser) {
                        echo '<script type="text/javascript">alert("Your payment was successfully processed by Ribs Circle!");</script>';
                    } else {
                        echo '<script type="text/javascript">alert("There was a problem processing your payment. Please try again.");</script>';
                    }
                }
                ?>


                <button type="submit">Pay Now</button>
            </form>
        </div>
    </div>

    <!-- Script to Retrieve Cart from localStorage and Display It -->
    <script>
        let currentPage = 1;
        const itemsPerPage = 10;

        function populateCart() {
            const cartTableBody = document.querySelector('.cart-table tbody');
            cartTableBody.innerHTML = ''; // Clear the table

            // Retrieve cart data from localStorage
            let cart = JSON.parse(localStorage.getItem('cart')) || [];

            // Check if cart is empty
            if (cart.length === 0) {
                cartTableBody.innerHTML = '<tr><td colspan="4">Your cart is empty.</td></tr>';
                updatePagination(0);
                return;
            }

            // Calculate total pages
            const totalPages = Math.ceil(cart.length / itemsPerPage);
            const startIndex = (currentPage - 1) * itemsPerPage;
            const endIndex = Math.min(startIndex + itemsPerPage, cart.length);

            let total = 0; // Initialize total price

            // Loop through each item in the current page range and create table rows
            for (let i = startIndex; i < endIndex; i++) {
                const item = cart[i];
                const itemTotalPrice = item.price * item.quantity; // Calculate item total
                total += itemTotalPrice; // Update total price

                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${item.description}</td>
                    <td>${item.quantity}</td>
                    <td>R${itemTotalPrice.toFixed(2)}</td>
                    <td><button onclick="removeItemFromCart(${item.id})">Remove</button></td>
                `;
                cartTableBody.appendChild(row);
            }

            // Add a row for the total price
            const totalRow = document.createElement('tr');
            totalRow.innerHTML = `
                <td colspan="2"><strong>Total</strong></td>
                <td><strong>R${total.toFixed(2)}</strong></td>
                <td></td>
            `;
            cartTableBody.appendChild(totalRow);

            updatePagination(totalPages);
        }

        // Function to update pagination info
        function updatePagination(totalPages) {
            const pageInfo = document.getElementById('pageInfo');
            pageInfo.textContent = `Page ${currentPage} of ${totalPages}`;

            document.getElementById('prevPage').disabled = currentPage === 1;
            document.getElementById('nextPage').disabled = currentPage === totalPages;
        }

        // Function to change the page
        function changePage(direction) {
            currentPage += direction;
            populateCart();
        }


        // Function to remove item from the cart
    function removeItemFromCart(id) {
        // Retrieve cart data from localStorage
        let cart = JSON.parse(localStorage.getItem('cart')) || [];

        // Find the index of the item to be removed
        const itemIndex = cart.findIndex(item => item.id === id);

        if (itemIndex !== -1) {
            // Remove the item from the cart
            cart.splice(itemIndex, 1);
            // Update localStorage
            localStorage.setItem('cart', JSON.stringify(cart));
            // Refresh the cart display
            populateCart();
        }
    }

    // Function to handle checkout button click
    document.getElementById('checkoutBtn').addEventListener('click', function () {
        const cart = JSON.parse(localStorage.getItem('cart')) || [];
        if (cart.length > 0) {
            openModal();
        } else {
            alert('Your cart is empty. Please add items before proceeding to checkout.');
        }
    });

    // Function to open the checkout modal
    function openModal() {
        document.getElementById('checkoutModal').style.display = 'block';
    }

    // Function to close the modal
    function closeModal() {
        document.getElementById('checkoutModal').style.display = 'none';
    }

    // Function to handle payment method selection and show respective fields
    function showPaymentFields() {
        const paymentMethod = document.getElementById('paymentMethod').value;
        document.getElementById('creditCardFields').classList.add('hidden');
        document.getElementById('paypalFields').classList.add('hidden');
        document.getElementById('bankTransferFields').classList.add('hidden');

        if (paymentMethod === 'creditCard') {
            document.getElementById('creditCardFields').classList.remove('hidden');
        } else if (paymentMethod === 'paypal') {
            document.getElementById('paypalFields').classList.remove('hidden');
        } else if (paymentMethod === 'bankTransfer') {
            document.getElementById('bankTransferFields').classList.remove('hidden');
        }
    }

    // Function to initialize the cart when the page loads
    window.onload = function () {
        populateCart();
    };


        window.onload = populateCart;
    </script>
</body>

</html>