<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ribs Circle - Reservation</title>
    <link rel="stylesheet" href="style.css">
    <style>
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
        /* Separation line */
        .separator {
            width: 100%;
            height: 1px;
            background-color: #e0e0e0;
            margin: 20px 0;
        }
        .reservation-form {
            width: 100%;
            max-width: 500px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f9f9f9;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        }
        table {
            width: 100%;
        }
        table td {
            padding: 10px;
            text-align: left;
        }
        table td input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            width: 100%;
            padding: 10px;
            background-color: #ff5733;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }
        button:hover {
            background-color: #ff4519;
        }
    </style>
</head>
<body>
    
<?php include '../header.php'; ?>

    <div class="separator"></div>

    <div class="reservation-form text-align: right;">
        <h2>Book a Table</h2>
        <form id="reservationForm" method="POST">
            <table>
                <tr>
                    <td><label for="name">Name:</label></td>
                    <td><input type="text" id="name" name="name" required></td>
                </tr>
                <tr>
                    <td><label for="phone">Phone Number:</label></td>
                    <td><input type="text" id="phone" name="phone" required></td>
                </tr>
                <tr>
                    <td><label for="date">Reservation Date:</label></td>
                    <td><input type="date" id="date" name="date" required></td>
                </tr>
                <tr>
                    <td><label for="time">Reservation Time:</label></td>
                    <td>
                        <select id="time" name="time" required>
                            <option value="">Select Time</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td><label for="guests">Number of Guests:</label></td>
                    <td><input type="number" id="guests" name="guests" required></td>
                </tr>
                <tr>
                    <td colspan="2">
                        <button type="submit">Book Now</button>
                    </td>
                </tr>
            </table>
        </form>
    </div>

    <div style="margin-top: 30px; text-align: left;">
        <h3>Visit Us at Ribs Circle</h3>
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3585.699011419371!2d28.20270737523956!3d-26.01067537719629!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x1e956c0a83aaaab5%3A0xc44435e574694c6b!2sRibs%20Circle!5e0!3m2!1sen!2sza!4v1729596240940!5m2!1sen!2sza" 
            width="60%" 
            height="450" 
            style="border:0;" 
            allowfullscreen="" 
            loading="lazy" 
            referrerpolicy="no-referrer-when-downgrade"></iframe>
    </div>

    <script>
    // Prevent selection of past dates
    document.addEventListener('DOMContentLoaded', function () {
        const today = new Date().toISOString().split('T')[0];
        document.getElementById('date').setAttribute('min', today);
        
        // Populate available times on page load
        populateAvailableTimes();
    });

    function populateAvailableTimes() {
        const timeSelect = document.getElementById('time');
        timeSelect.innerHTML = '<option value="">Select Time</option>'; // Reset options

        // Generate times from 12 PM to 10 PM in 30-minute intervals
        const startHour = 12; // 12 PM
        const endHour = 22; // 10 PM
        const interval = 30; // 30 minutes

        for (let hour = startHour; hour <= endHour; hour++) {
            for (let minute = 0; minute < 60; minute += interval) {
                const time = `${hour.toString().padStart(2, '0')}:${minute.toString().padStart(2, '0')}`;
                const option = document.createElement('option');
                option.value = time;
                option.textContent = time;
                timeSelect.appendChild(option);
            }
        }
    }

    document.getElementById('reservationForm').addEventListener('submit', function (e) {
        e.preventDefault();

        const name = document.getElementById('name').value;
        const phone = document.getElementById('phone').value;
        const date = document.getElementById('date').value;
        const time = document.getElementById('time').value;
        const guests = document.getElementById('guests').value;

        const whatsappNumber = "270812185717"; // Replace with your WhatsApp number
        const message = `Hi, I'd like to book a table at Ribs Circle. Details:\nName: ${name}\nPhone: ${phone}\nDate: ${date}\nTime: ${time}\nGuests: ${guests}`;
        const whatsappUrl = `https://wa.me/${whatsappNumber}?text=${encodeURIComponent(message)}`;

        window.location.href = whatsappUrl;
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
