<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dagwood Menu</title>
    <link rel="stylesheet" href="chicken.css">
    <!-- Font icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<?php include '../../header.php'; ?>

<body>

    <!--section1-->
    <section class="chicken" id="chicken">
        <h1>Welcome to Ribs Circle's Chicken Menu</h1>
        <p></p>
        <div class="menu-grid">
            <div class="menu-item">
                <img src="images/p2.jpg" alt="menu1">
                <h3>12 Pieces</h3>
                <a href="javascript:void(0)" class="btn" onclick="fetchItemDetails(1)">Crispy Fried Chicken Wings
                    <b>R85</b></a>
            </div>
            <div class="menu-item">
                <img src="images/meaty.jpg" alt="menu2">
                <h3>16 Pieces</h3>
                <a href="javascript:void(0)" class="btn" onclick="fetchItemDetails(2)">Crispy Fried Chicken Wings
                    <b>R99</b></a>
            </div>
            <div class="menu-item">
                <img src="images/meaty.jpg" alt="menu3">
                <h3>24 Pieces</h3>
                <a href="javascript:void(0)" class="btn" onclick="fetchItemDetails(3)">Crispy Fried Chicken Wings
                    <b>R159</b></a>
            </div>
        </div>
    </section>

    <!--section2-->
    <section class="dagwood" id="dagwood"></section>
    <p>

    </p>
    <div class="menu-grid">
        <div class="menu-item">
            <img src="images/p2.jpg" alt="menu1">
            <h3>Wings & Chips</h3>
            <a href="javascript:void(0)" class="btn" onclick="fetchItemDetails(4)">8x Wings & 280g Chips <b>R69</b></a>
        </div>
        <div class="menu-item">
            <img src="images/meaty.jpg" alt="menu2">
            <h3>Single Meal Combo 4</h3>
            <a href="javascript:void(0)" class="btn" onclick="fetchItemDetails(5)">250g Chicken Strips & 250g Chips
                <b>R69</b></a>
        </div>
        <div class="menu-item">
            <img src="images/meaty.jpg" alt="menu3">
            <h3>Single Meal Combo 4</h3>
            <a href="javascript:void(0)" class="btn" onclick="fetchItemDetails(6)">6 Wings & 250g Chips<b>R75</b></a>
        </div>
    </div>
    <p>

    </p>
    </section>

    <!--section3-->
    <section class="chicken" id="chicken"></section>
    <p>

    </p>
    <div class="menu-grid">
        <div class="menu-item">
            <img src="images/p2.jpg" alt="menu1">
            <center>
                <h3>Russian & Chips</h3>
            </center>
            <a href="javascript:void(0)" class="btn" onclick="fetchItemDetails(7)">Russian & 280g Chips <b>R110</b></a>
        </div>
        <div class="menu-item">
            <img src="images/meaty.jpg" alt="menu2">
            <h3>Chips</h3>
            <a href="javascript:void(0)" class="btn" onclick="fetchItemDetails(8)">400g Crispy Fried Chicken
                Strips<b>R69</b></a>
            &nbsp;
            <a href="javascript:void(0)" class="btn" onclick="fetchItemDetails(9)">600g Crispy Fried Chicken
                Strips<b>R99</b></a>
            &nbsp;
            <a href="javascript:void(0)" class="btn" onclick="fetchItemDetails(10)">800g Crispy Fried Chicken
                Strips<b>R130</b></a>
        </div>
        </section>
    </div>


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
        alert("Item added to the Cart");
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

        // Ensure totalPrice is a number before calling .toFixed()
        console.log(`Total Price: R${(parseFloat(totalPrice).toFixed(2))}`);
    }

    // Function to update the cart count display
    function updateCartCount() {
        const totalCount = selectedItems.reduce((sum, item) => sum + item.quantity, 0);
        document.getElementById('cart-count').innerText = totalCount;
    }

    // Fetch item details from the PHP server
    function fetchItemDetails(id) {
        // Replace 'get_item.php' with the actual path to your PHP script
        fetch(`get_chicken_item.php?id=${id}`)
            .then(response => response.json())
            .then(data => {
                if (data.status === "success") {
                    addItemToOrder(id, data.description, data.price);
                } else {
                    console.error('Item not found or an error occurred:', data.message);
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
    </script>

</body>

</html>