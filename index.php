<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
    <link rel="stylesheet" href="style.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body>
    <div class="main_container">
        <?php include 'header.php'; ?>
        <div class="content">
            <div class="left-side">
                <h1>We provide <br> the best local <br> food</h1>
                <p>Ribs Circle was inspired by the local kasi food called "Bunny Chow" <br>
                    The name "Ribs Circle" was derived from selling Ribs next to the circle.</p>
                <div class="buttons">
                    <button onclick="location.href='/RibsCircle_System/Reservations/reservations.php'">Reservations</button>
                </div>
                <div class="social-media-icons">
                    <a href="https://web.facebook.com/ribscircle" target="_blank"><i class="fab fa-facebook-f"></i></a>
                    <a href="https://vm.tiktok.com/ZMrmeMfYL/" target="_blank"><i class="fab fa-tiktok"></i></a>
                    <a href="https://www.instagram.com/ribscircle_za?utm_source=ig_web_button_share_sheet&igsh=ZDNlZDc0MzIxNw=="
                        target="_blank"><i class="fab fa-instagram"></i></a>
                </div>
            </div>
            <div class="right-side">
                <img src="assets/images/plate.jpg" alt="Local Food">
            </div>
        </div>

        <!-- Section 2 -->
        <section class="special" id="special">
            <h1>Our Special Dish</h1>
            <p>The top 2 people's favorite meals at Ribs Circle are our "Dagwood with Ribs" in the dagwoods menu, <br>
                and the "Meaty Combo" coming with 4 pieces of wings, strips, ribs, and chips.</p>
            <div class="menu-grid">
                <div class="menu-item">
                    <img src="assets/images/p2.jpg" alt="menu1">
                    <h3>Dagwood with Ribs</h3>
                    <p>Toasted Bread, Beef Patty, Lettuce, Cheese, Fried Onions, Ham, Bacon, 170g Ribs with 130g Chips
                    </p>
                    <a href="#menu-details" class="btn">Explore</a>
                </div>
                <div class="menu-item">
                    <img src="assets/images/meaty.jpg" alt="menu2">
                    <h3>Ribs & Wings</h3>
                    <p>300g Ribs, 4pc Chicken Wings with 250g Chips</p>
                    <a href="#service2-details" class="btn">Explore</a>
                </div>
                <div class="menu-item">
                    <img src="assets/images/meaty.jpg" alt="menu3">
                    <h3>Meaty Combo</h3>
                    <p>300g Ribs, 200g Chicken Strips with wings x6</p>
                    <a href="#menu-details" class="btn">Explore</a>
                </div>
            </div>
        </section>
        <div class="separate">
            <p></p>
        </div>

        <section class="aboutus" id="aboutus">
            <div class="about-container">
                <div class="about-image">
                    <img src="assets/images/staff-members.jpg" alt="About Us Image">
                </div>
                <div class="about-text">
                    <h2>About Us</h2>
                    <p>Ribs Circle was established to bring the best local kasi food experience to everyone.
                        Inspired by the famous "Bunny Chow" and the idea of selling ribs next to a popular circle in
                        Tembisa,
                        we bring a taste of home with every meal. Our food is made with passion and love,
                        and we believe in serving our customers with the same warmth we would serve our own family.
                        From our Dagwood specials to our delicious ribs, we strive to offer a unique, tasty,
                        and affordable dining experience.</p>
                </div>
            </div>
        </section>

        <div class="separate">
            <p></p>
        </div>
        <!--section 4-->
        <section class="section4">
            <div class="contactUS">
                <h2>CONTACT US</h2>
                <p>
                <div><i class="fas fa-phone"></i> 081 218 5717</div>
                <div><i class="fas fa-envelope"></i> ribscircle@gmail.com</div>
                <div><i class="fas fa-map-marker-alt"></i> 452 Corner Koti & Sparrow St, Moteong, Tembisa, 1632</div>
                </p>
            </div>
            <div class="TradingHours">
                <h2>Trading Hours</h2>
                <p>
                    Sunday: 9:30am - 9pm<br>
                    Monday: 9:30am - 9pm<br>
                    Tuesday: 9:30am - 9pm<br>
                    Wednesday: 9:30am - 9pm<br>
                    Thursday: 9:30am - 9pm<br>
                    Friday: 9:30am - 10pm<br>
                    Saturday: 9:30am - 10pm<br>
                </p>
            </div>
            <div class="logo">
                <h2>FOLLOW US</h2>
                <a href="https://web.facebook.com/ribscircle" target="_blank"><i class="fab fa-facebook-f"></i></a>
                <a href="https://vm.tiktok.com/ZMrmeMfYL/" target="_blank"><i class="fab fa-tiktok"></i></a>
                <a href="https://www.instagram.com/ribscircle_za?utm_source=ig_web_button_share_sheet&igsh=ZDNlZDc0MzIxNw=="
                    target="_blank"><i class="fab fa-instagram"></i></a>
                <p></p>
                <img src="assets/images/Logo.png" alt="Logo">
        </section>

        <!-- Footer -->
        <footer>
            <div class="copyright">
                <p>
                    @copyright by khanyisile</p>
            </div>
        </footer>
</body>

</html>