


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - G-Mart</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="index.css">
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar">
        <div class="container">
            <a href="index.php" class="logo">G-Mart</a>
            <ul class="nav-links">
                <li><a href="index.php">Home</a></li>
                <li><a href="product.php">Products</a></li>
                <li><a href="about.php" class="active">About </a></li>
                <li><a href="review.php">Review</a></li>
                <li><a href="contact.php">Contact</a></li>
            </ul>
            <div class="nav-icons">
                <!-- Search Bar -->
                

               
            </div>
        </div>
    </nav>

    <!-- About Section -->
   <!-- About Section -->
<section class="about">
    <div class="container">
        <h1 class="heading">About <span>Us</span></h1>
        <p>We are a trusted grocery store committed to delivering fresh, high-quality products to your doorstep. Founded in 2025, G-Mart aims to make shopping easy and convenient for everyone.</p>
       
</section>

<section class="about1">
    <img src="https://plus.unsplash.com/premium_photo-1667509297913-aec69c73fc7d?q=80&w=2072&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" alt="Fresh Vegetables">
    <div class="about-text">
        <p>At G-Mart, freshness is at the heart of everything we do. Our vibrant selection of vegetables—lush leafy greens, crisp cucumbers, juicy tomatoes, and more—are carefully sourced from trusted local farms. Each item is chosen for its peak flavor and nutritional value to ensure your meals are as healthy as they are delicious.</p>
        <p>Whether you're preparing a quick salad or a hearty stew, our produce section brings the colors and vitality of the farm right to your kitchen.</p>
        <a href="#" class="ab-btn">Learn more<i class="ab-i"></i></a>
    </div>
</section>


<section class="about1">
    <img src="https://images.unsplash.com/photo-1516253593875-bd7ba052fbc5?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" alt="Fresh Herbs">
    <div class="about-text">
        <p>At G-Mart, we believe the secret to great cooking lies in the freshest ingredients—and nothing is fresher than hand-picked, organic herbs. From vibrant basil and fragrant mint to earthy thyme and cilantro, our herbs are sourced directly from trusted local growers to bring pure, garden-fresh flavor straight to your kitchen.</p>
        <a href="#" class="ab-btn">Learn more<i class="ab-i"></i></a>
    </div>
</section>


<section class="about1">
    <img src="https://plus.unsplash.com/premium_photo-1678344176441-988d2e31455b?q=80&w=2071&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" alt="Grocery Aisle">
    <div class="about-text">
        <p>From pantry staples to global flavors, G-Mart offers a wide selection of everyday groceries in a clean, organized shopping environment. Whether you're picking up your weekly essentials or exploring new ingredients, our aisles are stocked with top-quality, affordable options for every kitchen.</p>
        <p>We partner with reliable suppliers to ensure every product—from grains and snacks to canned goods and beverages—is fresh, safe, and ready to meet your family's needs. G-Mart makes shopping both enjoyable and efficient.</p>
        <a href="#" class="ab-btn">Learn more<i class="ab-i"></i></a>
    </div>
</section>

<section class="about1">
    <img src="https://www.shutterstock.com/image-photo/young-farmer-using-mobile-phone-260nw-2481606347.jpg" alt="Local Farmer">
    <div class="about-text">
        <p>At G-Mart, we are proud to support men farms and local producers who dedicate themselves to sustainable agriculture. Farmers like the one featured here play a key role in bringing fresh, ethically sourced produce to your table every day.</p>
        <p>By choosing G-Mart, you're not only getting the best in freshness and nutrition, but you're also empowering communities and helping small-scale farmers thrive in a fair and eco-friendly supply chain.</p>
        <a href="#" class="ab-btn">Learn more<i class="ab-i"></i></a>
    </div>
</section>


    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="footer-grid">
                <div class="footer-about">
                    <h3><span class="logo-primary">G-mart</span> <span class="logo-secondary">shopping</span></h3>
                    <p>Your one-stop shop for all your shopping needs.</p>
                </div>
                <div class="footer-links">
                    <h4>Quick Links</h4>
                    <ul>
                    <li><a href="./index.php">Home</a></li>
                        <li><a href="product.php">Shop</a></li>
                        <li><a href="review.php">Reviews</a></li>
                        <li><a href="about.php">About</a></li>
                        <li><a href="contact.php" class="nav-link">Contact</a></li>
                    </ul>
                </div>
                <div class="footer-links">
                    <h4>Customer Service</h4>
                    <ul>
                        <li><a href="#">FAQ</a></li>
                        <li><a href="#">Shipping</a></li>
                        <li><a href="#">Returns</a></li>
                        <li><a href="#">Track Order</a></li>
                    </ul>
                </div>
                <div class="footer-newsletter">
                    <h4>Newsletter</h4>
                    <p>Subscribe for special offers</p>
                    <div class="newsletter-form">
                        <input type="email" placeholder="Your email">
                        <button class="btn btn-primary">Subscribe</button>
                    </div>
                </div>
            </div>
            <div class="footer-bottom">
                <p>© <span id="current-year"></span> Comfort Shopping. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Cart Modal -->
    <div id="cart-modal" class="modal">
        <div class="modal-content">
            <span id="close-modal" class="close">×</span>
            <h2>Your Cart</h2>
            <ul id="cart-items"></ul>
            <p>Total: $<span id="cart-total">0.00</span></p>
            <button id="checkout-btn" class="btn">Checkout</button>
        </div>
    </div>

    <script src="script.js"></script>
</body>

</html>