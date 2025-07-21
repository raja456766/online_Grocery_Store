<?php
session_start();

// Check if the user is logged in, otherwise set as "Guest"
if (!isset($_SESSION['user_name'])) {
    $_SESSION['user_name'] = "Guest";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - G-Mart</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="index.css">
    <style>
        .logo {
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
            font-size: 24px;
            font-weight: bold;
            color: #ffdb4d;
        }
        .logo-img {
            height: 50px;
            width: auto;
            object-fit: contain;
        }
        .logo-text {
            font-weight: bold;
            font-size: 1.2em;
        }
        .pin-validation {
            margin: 20px 0;
        }
        .pin-validation label {
            font-weight: bold;
        }
        .pin-validation input {
            padding: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 14px;
        }
        

        .logo {
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
            font-size: 24px;
            font-weight: bold;
            color: #ffdb4d;
        }
        .logo-img {
            height: 50px;
            width: auto;
            object-fit: contain;
        }
        .logo-text {
            font-weight: bold;
            font-size: 1.2em;
        }
        .pin-validation {
            margin: 20px 0;
        }
        .pin-validation label {
            font-weight: bold;
        }
        .pin-validation input {
            padding: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 14px;
        }
        /* --- G-Mart Highlights Section Styling --- */
        .gmart-highlights {
            background-color: #fffbe6;
            padding: 40px 20px;
            text-align: center;
        }
        .highlights-grid {
            display: flex;
            justify-content: center;
            gap: 30px;
            flex-wrap: wrap;
        }
        .highlight-card {
            background: #fff;
            border-radius: 12px;
            padding: 24px 18px;
            width: 220px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.08);
            display: flex;
            flex-direction: column;
            align-items: center;
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .highlight-card:hover {
            transform: translateY(-6px) scale(1.03);
            box-shadow: 0 6px 24px rgba(0,0,0,0.13);
        }
        .highlight-card i {
            font-size: 38px;
            color: #ffc107;
            margin-bottom: 12px;
        }
        .highlight-card h3 {
            font-size: 19px;
            margin-bottom: 8px;
            color: #333;
        }
        .highlight-card p {
            font-size: 15px;
            color: #666;
        }
    
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar">
        <div class="container">
            <a href="index.php" class="logo">
                <img src="images/logo.jpeg" alt="G-Mart Logo" class="logo-img">
                <span class="logo-text">G-Mart</span>
            </a>
            <ul class="nav-links">
                <li><a href="index.php" class="active">Home</a></li>
                <li><a href="product.php">Products</a></li>
                <li><a href="about.php">About</a></li>
                <li><a href="review.php">Review</a></li>
                <li><a href="contact.php">Contact</a></li>
            </ul>
           
            <a href="#" id="cart-btn" aria-label="View cart">
                <i class="fas fa-shopping-cart"></i>
                <span id="cart-count">0</span>
            </a>

        <div class="login">
    <?php if ($_SESSION['user_name'] !== "Guest"): ?>
        <span class="userh1">Welcome, <?php echo htmlspecialchars($_SESSION['user_name']); ?></span>
    <?php endif; ?>

    <!-- My Orders Icon -->
    <a href="my-orders.php" title="My Orders" style="margin-left: 15px;">
        <span class="userh1"><i class="fas fa-shopping-bag"></i></span>
    </a>

    <!-- Show Login/Logout button -->
    <?php if ($_SESSION['user_name'] !== "Guest"): ?>
        <a class="userh1" style="margin-left: 10px;" href="logout.php">Logout</a>
    <?php else: ?>
        <a class="userh1" style="margin-left: 10px;" href="login.php">Login</a>
    <?php endif; ?>
</div>


        </div>
    </nav>

    <!-- Welcome Section -->
    <section class="raja"><h1>Welcome to G-Mart</h1></section>

  <!-- PIN Code Display or Input -->
<section class="pin-validation">
    <div class="container">
        <?php if (isset($_SESSION['user_pin']) && isset($_SESSION['user_state'])): ?>
            <div style="background: #e0ffe0; padding: 15px; border-radius: 8px; border: 1px solid #b2f2b2; text-align:center;">
                <p style="font-size: 20px; color: #2d862d; font-weight: bold;">
                    Delivering to PIN: <?php echo htmlspecialchars($_SESSION['user_pin']); ?><br>
                    Block: <?php echo htmlspecialchars($_SESSION['user_state']); ?>
                </p>
            </div>
        <?php else: ?>
            <form action="validate-pin.php" method="POST" style="text-align:center;">
                <label for="pin" style="font-weight: bold;">Enter PIN Code:</label>
                <input type="text" id="pin" name="pin" required pattern="[1-9][0-9]{5}" title="Please enter a valid 6-digit Indian PIN code.">
                <button type="submit" class="btn">Validate</button>
            </form>
        <?php endif; ?>
    </div>
</section>

    <!-- Hero Section -->
    <section class="hero">
        <div class="slider">
            <img src="https://images.unsplash.com/photo-1583258292688-d0213dc5a3a8?fm=jpg&q=60&w=3000" alt="Grocery Image 1">
            <img src="https://img2.10bestmedia.com/Images/Photos/406816/Gelsons-Markets_55_660x440.jpg" alt="Grocery Image 2">
            <img src="https://recipes.net/wp-content/uploads/2024/02/what-is-produce-in-a-grocery-store-1709193417.jpg" alt="Grocery Image 3">
        </div>
        <div class="container">
            <p>Fresh groceries delivered to your doorstep within 15 minutes!</p>
            <a href="product.php" class="btn">Shop Now</a>
        </div>
    </section>

    
    <!-- Categories Section -->
    <section class="categories">
        <div class="container">
            <h2>Shop by Category</h2>
            <div class="category-grid">
                <a href="product.php?category=foods" class="category-card" data-category="fruits">
                    <img src="https://media.istockphoto.com/id/1457433817/photo/group-of-healthy-food-for-flexitarian-diet.jpg?s=612x612&w=0&k=20&c=v48RE0ZNWpMZOlSp13KdF1yFDmidorO2pZTu2Idmd3M=" alt="Fruits">
                    <h3>Fruits</h3>
                </a>
                <a href="product.php?category=vegetables" class="category-card" data-category="vegetables">
                    <img src="https://t3.ftcdn.net/jpg/01/47/51/60/360_F_147516063_hCXI8VUIdBYud0B0hhS3Yo5CFTT1a4g8.jpg" alt="Vegetables">
                    <h3>Vegetables</h3>
                </a>
                <a href="product.php?category=oils" class="category-card" data-category="oils">
                    <img src="https://media.istockphoto.com/id/1490062930/photo/soy-oil-bottle-and-dried-soybeans.jpg?s=612x612&w=0&k=20&c=aij2h_YY02ZIpYLg2fC8rP0j3ln4PiQmJRSWy6KOp1c=" alt="Oils">
                    <h3>Oils</h3>
                </a>
                
                <a href="product.php?category=masalas" class="category-card" data-category="masalas">
                    <img src="https://5.imimg.com/data5/SELLER/Default/2022/3/PM/II/FA/48785323/all-masala-items-500x500.jpeg" alt="masalas">
                    <h3>Masalas</h3>
                </a>
            </div>
        </div>
    </section>

  <!-- G-Mart Highlights Section -->
<section class="gmart-highlights">
    <div class="container highlights-grid">
        <div class="highlight-card">
            <i class="fas fa-star"></i>
            <h3>Best Quality</h3>
            <p>Only top-rated, hand-picked products.</p>
        </div>
        <div class="highlight-card">
            <i class="fas fa-leaf"></i>
            <h3>Fresh & Fast</h3>
            <p>Groceries delivered in 15 minutes.</p>
        </div>
        <div class="highlight-card">
            <i class="fas fa-headset"></i>
            <h3>24/7 Support</h3>
            <p>We're always here to help you.</p>
        </div>
        <div class="highlight-card">
            <i class="fas fa-lock"></i>
            <h3>Secure Payments</h3>
            <p>Your transactions are 100% protected.</p>
        </div>
    </div>
</section>


    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="footer-grid">
                <div class="footer-about">
                    <h3><span class="logo-primary">G-Mart</span></h3>
                    <p>Your one-stop shop for all your shopping needs.</p>
                </div>
                <div class="footer-links">
                    <h4>Quick Links</h4>
                    <ul>
                        <li><a href="index.php">Home</a></li>
                        <li><a href="product.php">Shop</a></li>
                        <li><a href="review.php">Reviews</a></li>
                        <li><a href="about.php">About</a></li>
                        <li><a href="contact.php">Contact</a></li>
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
                <p>© <span id="current-year"></span> G-Mart Shopping. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script src="scripts.js"></script>
</body>
</html>