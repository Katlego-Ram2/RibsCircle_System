<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dagwood Menu</title>
    <link rel="stylesheet" href="Ribs.css">
    <!-- Font icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body>
    <?php include '../../header.php'; ?>

    <!-- Section 1 -->
    <section class="ribs" id="ribs">
        <h1>Welcome to Ribs Circle's Ribs Menu</h1>
        <div class="menu-grid">
            <div class="menu-item">
                <img src="images/p2.jpg" alt="menu1">
                <h3>Ribs</h3>
                <a href="javascript:void(0)" class="btn" onclick="fetchItemDetails(1)">300g Ribs & 250g Chips
                    <b>R80</b></a>
            </div>
            <div class="menu-item">
                <img src="images/meaty.jpg" alt="menu2">
                <h3>Ribs & Wings</h3>
                <a href="javascript:void(0)" class="btn" onclick="fetchItemDetails(2)">300g Ribs, 4pc Chicken Wings with
                    250g Chips <b>R99</b></a>
            </div>
            <div class="menu-item">
                <img src="images/meaty.jpg" alt="menu3">
                <h3>Meaty Combo</h3>
                <a href="javascript:void(0)" class="btn" onclick="fetchItemDetails(3)">300g Ribs, 200g Chicken Strips
                    with 6x Wings <b>R159</b></a>
            </div>
        </div>

        <!-- Section 2 -->
        <div class="menu-grid">
            <div class="menu-item">
                <img src="images/p2.jpg" alt="menu1">
                <h3>BBQ or HOT RIBS</h3>
                <a href="javascript:void(0)" class="btn" onclick="fetchItemDetails(4)">600g Ribs (Serves
                    2)<b>R69</b></a>
                &nbsp;
                <a href="javascript:void(0)" class="btn" onclick="fetchItemDetails(5)">800g Ribs (Serves
                    4)<b>R210</b></a>
                &nbsp;
                <a href="javascript:void(0)" class="btn" onclick="fetchItemDetails(6)">1.1kg Ribs (Serves
                    6)<b>R300</b></a>
            </div>
            <div class="menu-item">
                <img src="images/meaty.jpg" alt="menu2">
                <h3>Ribs Meals</h3>
                <a href="javascript:void(0)" class="btn" onclick="fetchItemDetails(7)">600g Ribs & 400g Chips (Serves
                    2)<b>R189</b></a>
                &nbsp;
                <a href="javascript:void(0)" class="btn" onclick="fetchItemDetails(8)">800g Ribs & 550g Chips (Serves
                    4)<b>R240</b></a>
                &nbsp;
                <a href="javascript:void(0)" class="btn" onclick="fetchItemDetails(9)">1.1kg Ribs & 1.1kg Chips (Serves
                    6)<b>R379</b></a>
            </div>
            <div class="menu-item">
                <img src="images/meaty.jpg" alt="menu2">
                <h3>Russian Cheese Wrap</h3>
                <a href="javascript:void(0)" class="btn" onclick="fetchItemDetails(10)">Russian, Cheese, Rotti Wrap with
                    130g Chips<b>R69</b></a>
            </div>
        </div>
    </section>

    <script>
    // Array to hold selected items
    let selectedItems = JSON.parse(localStorage.getItem('cart')) || [];
    let totalPrice = selectedItems.reduce((sum, item) => sum + (item.price * item.quantity), 0);

    // Function to add item to the order
    function addItemToOrder(id, description, price) {
        price = parseFloat(price); // Ensure price is a number
        const existingItemIndex = selectedItems.findIndex(item => item.id === id);

        if (existingItemIndex !== -1) {
            selectedItems[existingItemIndex].quantity += 1;
        } else {
            selectedItems.push({
                id,
                description,
                price,
                quantity: 1
            });
        }

        totalPrice += price;
        localStorage.setItem('cart', JSON.stringify(selectedItems));
        updateCartCount();
        displaySelectedItems();
        alert("Item added to the Cart");
    }

    // Function to display selected items and total price
    function displaySelectedItems() {
        console.clear();
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
        const cartCountElement = document.getElementById('cart-count');
        if (cartCountElement) {
            cartCountElement.innerText = totalCount;
        }
    }

    // Fetch item details and update order
    function fetchItemDetails(id) {
        fetch(`get_ribs_item.php?id=${id}`)
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    addItemToOrder(data.id, data.description, data.price);
                } else {
                    alert(data.message); // Alert user if the item is not found
                }
            })
            .catch(error => {
                console.error('Error fetching item details:', error);
                alert(
                    'There was an error fetching item details. Please try again later.'
                ); // User-friendly error message
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