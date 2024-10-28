<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dagwood Menu</title>
    <link rel="stylesheet" href="dagwood.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body>
    <?php include '../../header.php'; ?>
    <div class="separate">
        <p></p>
    </div>
    <!--section1-->
    <section class="dagwood" id="dagwood">
        <h1>Welcome to Ribs Circle's Dagwood Menu</h1>
        <p>Ribs Circle's dagwoods were inspired by the local kotas that were made in slices, Lucky Mazibuko was creative
            and passionate enough to make delicious dagwoods.</p>
        <div class="menu-grid">
            <div class="menu-item">
                <img src="images/p2.jpg" alt="menu1">
                <h3>Ham & Cheese Dagwood</h3>
                <a href="javascript:void(0)" class="btn" onclick="fetchItemDetails(1)">Toasted Bread, Tomato, Lettuce,
                    Cheese, Ham with 120g Chips <b>R32</b></a>
                <a href="javascript:void(0)" class="btn" onclick="fetchItemDetails(2)">Add 4pc Chicken Wings
                    <b>R65</b></a>
            </div>
            <div class="menu-item">
                <img src="images/meaty.jpg" alt="menu2">
                <h3>Chicken Mayo Dagwood</h3>
                <a href="javascript:void(0)" class="btn" onclick="fetchItemDetails(5)">Toasted Bread, Tomato, Lettuce,
                    100g Chicken Mayo with 120g Chips <b>R55</b></a>
                <a href="javascript:void(0)" class="btn" onclick="fetchItemDetails(2)">Add 130g Chicken Strips
                    <b>R85</b></a>
            </div>
            <div class="menu-item">
                <img src="images/meaty.jpg" alt="menu3">
                <h3>Beef/Chicken Dagwood</h3>
                <a href="javascript:void(0)" class="btn" onclick="fetchItemDetails(3)">Toasted Bread, Beef/Chicken
                    Patty, Tomato, Lettuce, Fried Onions with 120g Chips <b>R56</b></a>
                &nbsp;
                <a href="javascript:void(0)" class="btn" onclick="fetchItemDetails(3)">Add 130g Chicken Strips
                    <b>R80</b></a>
            </div>
        </div>
    </section>

    <!--section2-->
    <section class="dagwood" id="dagwood">
        <div class="menu-grid">
            <div class="menu-item">
                <img src="images/p2.jpg" alt="menu1">
                <h3>Beef & Egg Dagwood</h3>
                <a href="javascript:void(0)" class="btn" onclick="fetchItemDetails(4)">Toasted Bread, Beef/Chicken
                    Patty, Lettuce, Egg, Fried Onions with 120g Chips <b>R61</b></a>
                &nbsp;
                <a href="javascript:void(0)" class="btn" onclick="fetchItemDetails(4)">Add Smoked Russian <b>R79</b></a>
            </div>
            <div class="menu-item">
                <img src="images/meaty.jpg" alt="menu2">
                <h3>Beef & Cheese Dagwood</h3>
                <a href="javascript:void(0)" class="btn" onclick="fetchItemDetails(5)">Toasted Bread, Beef/Chicken
                    Patty, Lettuce, Cheese, Egg, Fried Onions with 120g Chips <b>R64</b></a>
                &nbsp;
                <a href="javascript:void(0)" class="btn" onclick="fetchItemDetails(5)">Add 4pc Chicken Wings
                    <b>R99</b></a>
            </div>
            <div class="menu-item">
                <img src="images/meaty.jpg" alt="menu3">
                <h3>Bacon & Ham Dagwood</h3>
                <a href="javascript:void(0)" class="btn" onclick="fetchItemDetails(6)">Toasted Bread, Beef/Chicken
                    Patty, Lettuce, Ham, Bacon, Fried Onions with 120g Chips <b>R64</b></a>
                &nbsp;
                <a href="javascript:void(0)" class="btn" onclick="fetchItemDetails(6)">Add Smoked Russian <b>R85</b></a>
            </div>
        </div>
    </section>

    <!--section3-->
    <section class="dagwood" id="dagwood">
        <div class="menu-grid">
            <div class="menu-item">
                <img src="images/p2.jpg" alt="menu1">
                <h3>Dagwood with Ribs</h3>
                <a href="javascript:void(0)" class="btn" onclick="fetchItemDetails(7)">Toasted Bread, Beef/Chicken
                    Patty, Lettuce, Cheese, Ham, Bacon, Fried Onions, 120g Chips with 170g Ribs <b>R110</b></a>
            </div>
            <div class="menu-item">
                <img src="images/meaty.jpg" alt="menu2">
                <h3>Chips</h3>
                <a href="javascript:void(0)" class="btn" onclick="fetchItemDetails(14)">300g Chips (Serves 1)
                    <b>R25</b></a>
                &nbsp;
                <a href="javascript:void(0)" class="btn" onclick="fetchItemDetails(15)">450g Chips (Serves 2)
                    <b>R35</b></a>
                &nbsp;
                <a href="javascript:void(0)" class="btn" onclick="fetchItemDetails(16)">600g Chips (Serves 3)
                    <b>R50</b></a>
            </div>
        </div>
    </section>

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