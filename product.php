<?php
@include 'dbcon.php';
session_start();

// Check if the user is logged in, otherwise set as "Guest"
if (!isset($_SESSION['user_name'])) {
    $_SESSION['user_name'] = "Guest";
}


// Get category from URL, default to 'all' if not set
$category = isset($_GET['category']) ? strtolower($_GET['category']) : 'all';

// Get selected price range from URL
$priceRange = isset($_GET['price_range']) ? $_GET['price_range'] : 'all';
// Define min and max price based on selected range
$min = null;
$max = null;
if ($priceRange === '50-100') {
    $min = 50;
    $max = 100;
} elseif ($priceRange === '100-200') {
    $min = 100;
    $max = 200;
} elseif ($priceRange === '200-300') {
    $min = 200;
    $max = 300;
}


// Define products with categories
$products = [
    // Vegetables
    ['name' => 'Carrot', 'price' => 49.00, 'img' => 'https://media.istockphoto.com/id/1388403435/photo/fresh-carrots-isolated-on-white-background.jpg?s=612x612&w=0&k=20&c=XmrTb_nASc7d-4zVKUz0leeTT4fibDzWi_GpIun0Tlc=', 'category' => 'vegetables', 'unit' => 'kg'],
    ['name' => 'Cucumber', 'price' => 39.00, 'img' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTE623s2qhrV8wclXeG8CyuvOg-R1H71buOjw&s', 'category' => 'vegetables', 'unit' => 'kg'],
    ['name' => 'Tomato', 'price' => 89.00, 'img' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQMyFxw408GVqWfdVcoWMwIO26PRfHz9sDJGQ&s', 'category' => 'vegetables', 'unit' => 'kg'],
    ['name' => 'Onion', 'price' => 59.00, 'img' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcR72ctIeVztN5l6MODTQsV6SplFKCJKOFb1gg&s', 'category' => 'vegetables', 'unit' => 'kg'],
    ['name' => 'Cauli Flower', 'price' => 59.00, 'img' => 'https://www.shutterstock.com/image-photo/freshly-harvested-cauliflower-scientifically-known-260nw-2550579749.jpg', 'category' => 'vegetables', 'unit' => 'kg'],
    ['name' => 'Potato', 'price' => 40.00, 'img' => 'https://5.imimg.com/data5/SELLER/Default/2023/11/360220981/BZ/FG/EQ/135806079/organic-potato-vegetable.jpg', 'category' => 'vegetables', 'unit' => 'kg'],
    ['name' => 'Ladies Finger', 'price' => 19.00, 'img' => 'https://media.istockphoto.com/id/2149005548/photo/heap-of-fresh-okra-or-ladys-finger-isolated-on-white-background-its-scientific-name-is.jpg?s=612x612&w=0&k=20&c=9N8VxA-9H68kZho7kA2cWUCsMqTwBTbL3CF7amM2Mh4=', 'category' => 'vegetables', 'unit' => 'kg'],
    ['name' => 'Bean', 'price' => 39.00, 'img' => 'https://5.imimg.com/data5/ANDROID/Default/2022/11/JL/SK/UP/143656523/product-jpeg.jpg', 'category' => 'vegetables', 'unit' => 'kg'],

    
    // Fruits
    ['name' => 'Apple', 'price' => 99.00, 'img' => 'https://media.istockphoto.com/id/184276818/photo/red-apple.jpg?s=612x612&w=0&k=20&c=NvO-bLsG0DJ_7Ii8SSVoKLurzjmV0Qi4eGfn6nW3l5w=', 'category' => 'foods', 'unit' => 'kg'],
    ['name' => 'Banana', 'price' => 80.00, 'img' => 'https://media.istockphoto.com/id/619046500/photo/bananas.jpg?s=612x612&w=0&k=20&c=p5-v1iKwhOhw5cFjfx83qgaZcOBSVpUuicZi4VIGF2Y=', 'category' => 'foods', 'unit' => 'kg'],
    ['name' => 'Orange', 'price' => 29.00, 'img' => 'https://media.istockphoto.com/id/477836156/photo/orange-fruit-isolated-on-white.jpg?s=612x612&w=0&k=20&c=NQYciPqF0kRqnDMx7Vy96Qhtx2c37OiKPXtjMR3Oy-Y=', 'category' => 'foods', 'unit' => 'kg'],
    ['name' => 'Green Grapes', 'price' => 99.00, 'img' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQW1UfmrvXSR2YJgoNOK5-HINPsFA_kHHkNgQ&s', 'category' => 'foods', 'unit' => 'kg'],
    ['name' => 'Black Grapes', 'price' => 109.00, 'img' => 'https://www.shutterstock.com/image-photo/dark-blue-grape-leaves-isolated-600nw-604667843.jpg', 'category' => 'foods', 'unit' => 'kg'],
    ['name' => 'Pine Apple', 'price' => 89.00, 'img' => 'https://media.istockphoto.com/id/831291474/photo/pineapple-isolated-on-white-background.jpg?s=612x612&w=0&k=20&c=ozyA1aMGkE2J8tX1Q5-UWx467T0o0aRlq97cIu4-Afg=', 'category' => 'foods', 'unit' => 'kg'],
    ['name' => 'Mango', 'price' => 79.00, 'img' => 'https://media.istockphoto.com/id/1352881713/photo/mango-fruit-with-drops-isolated-on-white-background.jpg?s=612x612&w=0&k=20&c=xNgofvhPOsksKtOMK9sbvQ2qZpMS6WQ3UC6Omv7g8-0=', 'category' => 'foods', 'unit' => 'kg'],
    ['name' => 'Dragon Fruit', 'price' => 129.00, 'img' => 'https://media.istockphoto.com/id/1364034447/photo/fresh-pitahaya-on-white-background-dragon-fruit.jpg?s=612x612&w=0&k=20&c=mkYotHioKj-eMD5mB6t3f_BxFOucqN828Sdvk5bCqFU=', 'category' => 'foods', 'unit' => 'kg'],
    


    // Oils
    ['name' => 'Sunrich Oil', 'price' => 129.00, 'img' => 'https://5.imimg.com/data5/SELLER/Default/2021/6/FH/IP/UF/45780338/1-litre-fortune-refined-sunflower-oil.jpg', 'category' => 'oils', 'unit' => 'lt'],
    ['name' => 'RuchiGold Oil', 'price' => 99.00, 'img' => 'https://5.imimg.com/data5/SELLER/Default/2022/8/QK/GF/TB/82054468/ruchi-gold-palmen-oil-1660736992952.jpg', 'category' => 'oils', 'unit' => 'lt'],
    ['name' => 'Freedom Oil', 'price' => 119.00, 'img' => 'https://encrypted-tbn1.gstatic.com/shopping?q=tbn:ANd9GcRmUb4Nlref5uEk12w8--s-v_ffbxsa2rHV855d6nUsMuElSochXD5guy5W9Qxq0LJvSY9nzBhyuMHmABF5frxX9xBZ9rQUAbk4uuxfds5asQ0jl4Ftbn-z', 'category' => 'oils', 'unit' => 'lt'],
    ['name' => 'Fortune Oil', 'price' => 109.00, 'img' => 'https://rukminim2.flixcart.com/image/1200/1200/xif0q/edible-oil/9/l/h/-original-imahadyey2fzg2cz.jpeg', 'category' => 'oils', 'unit' => 'lt'],
    
     // masalas
     ['name' => 'Everest Masala', 'price' => 59.00, 'img' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRIJ1DQ3CcQdPN0G5aeeZ9WqaJK-DmBhRXi4Q&s', 'category' => 'masalas', 'unit' => 'kg'],
     ['name' => 'Aachi Masala', 'price' => 49.00, 'img' => 'https://m.media-amazon.com/images/I/51idpj3g2bL.jpg', 'category' => 'masalas', 'unit' => 'kg'],
     ['name' => 'Priya Masala', 'price' => 69.00, 'img' => 'https://priyafoods.com/cdn/shop/products/chickenmasala100g.jpg?v=1676111997', 'category' => 'masalas', 'unit' => 'kg'],
     ['name' => 'Suhana Masala', 'price' => 79.00, 'img' => 'https://suhana.com/cdn/shop/files/SUH-CM-200g-pouch-preview.png?v=1707833846', 'category' => 'masalas', 'unit' => 'kg'],
     
    // Add more oils or other categories as needed

];

$filteredProducts = array_filter($products, function($product) use ($category, $min, $max) {
    $price = $product['price'];
    return ($category === 'all' || $product['category'] === $category) &&
           (is_null($min) || $price >= $min) &&
           (is_null($max) || $price <= $max);
});

$sql = "SELECT * FROM products";
$result = $conn->query($sql);

$adminProducts = [];
while ($row = $result->fetch_assoc()) {
    // Normalize category to lowercase and trim for filtering
    $row['category'] = strtolower(trim($row['category']));
    // Add unit if not set (default to 'kg')
    $row['unit'] = isset($row['unit']) && $row['unit'] ? $row['unit'] : 'kg';
    // Filter by category and price
    $show = ($category === 'all' || $row['category'] === $category) &&
            (is_null($min) || $row['price'] >= $min) &&
            (is_null($max) || $row['price'] <= $max);
    if ($show) {
        $adminProducts[] = $row;
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products - G-Mart</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="index.css">
    <style>
        .price-filter {
    display: flex;
    justify-content: center;
    align-items: center;
    margin: 20px auto;
    padding: 10px 20px;
    background-color: #f4f4f4;
    border-radius: 10px;
    width: fit-content;
    font-family: Arial, sans-serif;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

.price-filter label {
    margin-right: 10px;
    font-weight: bold;
    font-size: 16px;
}

.price-filter select {
    padding: 5px 10px;
    border-radius: 5px;
    border: 1px solid #ccc;
    font-size: 15px;
    cursor: pointer;
    transition: all 0.3s ease;
}

.price-filter select:hover {
    border-color: #555;
}

    </style>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar">
        <div class="container">
            <a href="index.php" class="logo">G-Mart</a>
            <ul class="nav-links">
                <li><a href="index.php">Home</a></li>
                <li><a href="product.php" class="active">Products</a></li>
                <li><a href="about.php">About</a></li>
                <li><a href="review.php">Review</a></li>
                <li><a href="contact.php">Contact</a></li>
            </ul>
            <div class="nav-icons">
               
                <a href="#" id="cart-btn" aria-label="View cart">
                    <i class="fas fa-shopping-cart"></i>
                    <span id="cart-count">0</span>
                </a>
               
            </div>
        </div>
    </nav>
 <!-- Price Filter Form -->
 <form method="GET" class="price-filter">
        <input type="hidden" name="category" value="<?php echo htmlspecialchars($category); ?>">
        <label for="price-range">Price Range:</label>
        <select name="price_range" id="price-range" onchange="this.form.submit()">
            <option value="all" <?php echo $priceRange === 'all' ? 'selected' : ''; ?>>All</option>
            <option value="50-100" <?php echo $priceRange === '50-100' ? 'selected' : ''; ?>>₹50 - ₹100</option>
            <option value="100-200" <?php echo $priceRange === '100-200' ? 'selected' : ''; ?>>₹100 - ₹200</option>
            <option value="200-300" <?php echo $priceRange === '200-300' ? 'selected' : ''; ?>>₹200 - ₹300</option>
        </select>
    </form>
    <!-- Products Section -->
    <section class="products">
        <div class="container">
            <h1 class="heading">Our <span>
                    <?php echo ucfirst($category === 'all' ? 'Products' : $category); ?>
                </span></h1>
            <div class="product-grid">
                <?php foreach ($filteredProducts as $product): ?>
                <div class="product-card">
                    <img src="<?php echo $product['img']; ?>" alt="<?php echo $product['name']; ?>">
                    <h3>
                        <?php echo $product['name']; ?>
                    </h3>
                    <p class="price" data-base-price="<?php echo $product['price']; ?>">₹
                        <?php echo $product['price']; ?> /
                        <?php echo $product['unit']; ?>
                    </p>
                    <select class="quantity-select" data-name="<?php echo $product['name']; ?>">
                        <option value="0.25" data-unit="<?php echo $product['unit']; ?>">
                            <?php echo $product['unit'] === 'lt' ? '250ml' : '250gm'; ?>
                        </option>
                        <option value="0.5" data-unit="<?php echo $product['unit']; ?>">
                            <?php echo $product['unit'] === 'lt' ? '500ml' : '500gm'; ?>
                        </option>
                        <option value="1" data-unit="<?php echo $product['unit']; ?>" selected>
                            <?php echo $product['unit'] === 'lt' ? '1lt' : '1kg'; ?>
                        </option>
                        <option value="1.5" data-unit="<?php echo $product['unit']; ?>">
                            <?php echo $product['unit'] === 'lt' ? '1.5lt' : '1.5kg'; ?>
                        </option>
                        <option value="2" data-unit="<?php echo $product['unit']; ?>">
                            <?php echo $product['unit'] === 'lt' ? '2lt' : '2kg'; ?>
                        </option>
                    </select>


                   
                    
                  <!-- In the product card section -->
<button class="add-to-cart" 
    data-name="<?php echo $product['name']; ?>"
    data-price="<?php echo $product['price']; ?>"
    data-img="<?php echo $product['img']; ?>">Add Cart</button>
<button class="buy-now" 
    data-name="<?php echo $product['name']; ?>"
    data-price="<?php echo $product['price']; ?>"
    data-img="<?php echo $product['img']; ?>">Buy Now</button>
                </div>
                <?php endforeach; ?>
                

                    <!-- Admin-added products from database -->
                <?php foreach ($adminProducts as $row): ?>
                <div class="product-card">
                    <img src="images/<?php echo htmlspecialchars($row['image']); ?>" alt="<?php echo htmlspecialchars($row['pname']); ?>">
                    <h3><?php echo htmlspecialchars($row['pname']); ?></h3>
                    <p class="price" data-base-price="<?php echo $row['price']; ?>">₹<?php echo $row['price']; ?> / <?php echo isset($row['unit']) ? $row['unit'] : 'kg'; ?></p>
                    <select class="quantity-select" data-name="<?php echo htmlspecialchars($row['pname']); ?>">
                        <option value="0.25" data-unit="<?php echo isset($row['unit']) ? $row['unit'] : 'kg'; ?>"><?php echo (isset($row['unit']) && $row['unit'] === 'lt') ? '250ml' : '250gm'; ?></option>
                        <option value="0.5" data-unit="<?php echo isset($row['unit']) ? $row['unit'] : 'kg'; ?>"><?php echo (isset($row['unit']) && $row['unit'] === 'lt') ? '500ml' : '500gm'; ?></option>
                        <option value="1" data-unit="<?php echo isset($row['unit']) ? $row['unit'] : 'kg'; ?>" selected><?php echo (isset($row['unit']) && $row['unit'] === 'lt') ? '1lt' : '1kg'; ?></option>
                        <option value="1.5" data-unit="<?php echo isset($row['unit']) ? $row['unit'] : 'kg'; ?>"><?php echo (isset($row['unit']) && $row['unit'] === 'lt') ? '1.5lt' : '1.5kg'; ?></option>
                        <option value="2" data-unit="<?php echo isset($row['unit']) ? $row['unit'] : 'kg'; ?>"><?php echo (isset($row['unit']) && $row['unit'] === 'lt') ? '2lt' : '2kg'; ?></option>
                    </select>
                    <button class="add-to-cart" 
                        data-name="<?php echo htmlspecialchars($row['pname']); ?>"
                        data-price="<?php echo $row['price']; ?>"
                        data-img="images/<?php echo htmlspecialchars($row['image']); ?>">Add Cart</button>
                    <button class="buy-now" 
                        data-name="<?php echo htmlspecialchars($row['pname']); ?>"
                        data-price="<?php echo $row['price']; ?>"
                        data-img="images/<?php echo htmlspecialchars($row['image']); ?>">Buy Now</button>
                </div>
                <?php endforeach; ?>

                <?php if (empty($filteredProducts) && empty($adminProducts)): ?>
                <p>No products found in this category.</p>
                <?php endif; ?>
            </div>
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
            <p>Total: ₹<span id="cart-total">0.00</span></p>
            <button id="checkout-btn" class="btn"><a href="order.php">Checkout</a></button>
        </div>
    </div>

    <script src="scripts.js"></script>
</body>

</html>