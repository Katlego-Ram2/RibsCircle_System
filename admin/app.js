// app.js

// Define the menu structure similar to your PHP array
const menuItems = {
    'Admin View': '../admin/index.php',
    'Cards': 'cards.html',
};

// Function to load content based on the route
function navigate(url) {
    const contentDiv = document.getElementById('content');
    contentDiv.innerHTML = `<h1>Loading ${url}...</h1>`;
    // Simulate loading content (replace this with fetch in a real application)
    history.pushState({ url }, '', url);
}

// Function to generate admin menu HTML
function generateAdminMenu(menu, parentElement) {
    for (const [key, value] of Object.entries(menu)) {
        const a = document.createElement('a');
        a.className = 'collapse-item';
        a.href = value;
        a.textContent = key;
        a.onclick = (event) => {
            event.preventDefault();
            navigate(value);
        };
        parentElement.appendChild(a);
    }
}

// Initial menu generation
const adminMenu = document.getElementById('admin-menu');
generateAdminMenu(menuItems, adminMenu);

// Handle back/forward navigation
window.onpopstate = function(event) {
    if (event.state) {
        navigate(event.state.url);
    }
};

// Load initial content based on the URL
window.onload = function() {
    const initialUrl = location.pathname;
    navigate(initialUrl);
};
