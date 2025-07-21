<?php
@include 'dbcon.php';
session_start();


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - G-Mart</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
    <link rel="stylesheet" href="index.css">
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar">
        <div class="container">
            <div class="logo-container">
                <a href="index.php" class="logo">G-Mart</a>
            </div>
            <ul class="nav-links">
                <li><a href="index.php">Home</a></li>
                <li><a href="product.php">Products</a></li>
                <li><a href="about.php">About</a></li>
                <li><a href="review.php" class="active">Review</a></li>
                <li><a href="contact.php">Contact</a></li>
            </ul>
            <div class="nav-icons">
                <!-- Search Bar -->
                
                
            </div>
        </div>
    </nav>
    <!-- review section -->
    <section class="review" id="review">
        <h1 class="heading">Customer <span>Review</span></h1>

        <div class="review-slider">
            <div class="wrapper">
                <div class="box">
                <img src="images/raja.jpg" >
                  <p>"Quality is good, but sometimes a few items are out of stock. Would love to see more local seasonal veggies."</p>
                    <h3>Raja Bhuyan</h3>
                    <div class="stars">
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star-half"></i>
                    </div>
                </div>


               







               
             




                <div class="box">
                <img src="images/rabis.jpg" >
                  <p>"The organic options are amazing. I especially like the spinach and tomatoes—they taste just like home-grown."</p>
                    <h3>Rabi Narayan Bisoyi</h3>
                    <div class="stars">
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star-half"></i>
                    </div>
                </div>



                <div class="box">
                <img src="images/ritiks.jpg" >
                 <p>"Great variety and reasonable prices. The staff is friendly and always helps me pick the best produce."</p>
                    <h3>Ritik Bhuyan</h3>
                    <div class="stars">
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star-half"></i>
                    </div>
                </div>
                <div class="box">
                      <img src="images/babu.jpg" >
                    <p>"Always fresh and crisp! I love shopping here because the vegetables last longer than those from the supermarket."</p>
                    <h3>Rudransu Bhuyan</h3>
                    <div class="stars">
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star-half"></i>
                    </div>
                </div>
            </div>
        </div>
    </section>





    <!-- footer -->
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
            <p>Total: ₹<span id="cart-total">0.00</span></p>
            <button id="checkout-btn" class="btn">Checkout</button>
        </div>
    </div>