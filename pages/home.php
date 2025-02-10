<?php
session_start();
require '../function/config.php'; // Include your database configuration file

// Fetch categories
$categories_query = "SELECT * FROM categories";
$categories_result = $conn->query($categories_query);

// Fetch featured products (randomly picked)
$featured_query = "SELECT * FROM seller_products ORDER BY RAND() LIMIT 4";
$featured_result = $conn->query($featured_query);
?>

<?php include 'header.php'; ?>

<!-- Custom CSS -->
<style>
    body {
        font-family: 'Arial', sans-serif;
        background-color: #f5f5f5;
    }

    .welcome-title {
        margin: 20px 0;
        text-align: center;
        color: #ff69b4;
        font-size: 2.5em;
        font-weight: bold;
    }

    .category-card,
    .product-card {
        margin: 15px;
        border: none;
        border-radius: 15px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        background-color: #ffffff;
        transition: transform 0.3s, box-shadow 0.3s;
    }

    .category-card:hover,
    .product-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
    }

    .category-card img,
    .product-card img {
        border-top-left-radius: 15px;
        border-top-right-radius: 15px;
        transition: transform 0.3s;
    }

    .category-card img:hover,
    .product-card img:hover {
        transform: scale(1.05);
    }

    .category-card .card-body,
    .product-card .card-body {
        text-align: center;
        padding: 20px;
    }

    .category-card .card-title,
    .product-card .card-title {
        color: #ff69b4;
        font-size: 1.5em;
        font-weight: bold;
    }

    .product-card .card-text {
        color: #4a4a4a;
        font-size: 1.2em;
    }

    .product-card .btn-primary {
        background-color: #ff69b4;
        border: none;
        transition: background-color 0.3s;
    }

    .product-card .btn-primary:hover {
        background-color: #ff1493;
    }

    .search-bar {
        margin: 20px 0;
        text-align: center;
    }

    .search-bar input {
        width: 70%;
        padding: 10px;
        border-radius: 25px;
        border: 1px solid #ddd;
        transition: box-shadow 0.3s;
    }

    .search-bar input:focus {
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        outline: none;
    }

    .search-bar button {
        padding: 10px 20px;
        border-radius: 25px;
        border: none;
        background-color: #ff69b4;
        color: #ffffff;
        transition: background-color 0.3s;
    }

    .search-bar button:hover {
        background-color: #ff1493;
    }

    .category-card {
        border: none;
        border-radius: 15px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        background-color: #ffffff;
        transition: transform 0.3s, box-shadow 0.3s;
    }

    .category-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
    }

    .category-card img {
        border-top-left-radius: 15px;
        border-bottom-left-radius: 15px;
        transition: transform 0.3s;
    }

    .category-card img:hover {
        transform: scale(1.05);
    }

    .category-card .card-body {
        text-align: left;
        padding: 20px;
    }

    .category-card .card-title {
        color: #ff69b4;
        font-size: 1.5em;
        font-weight: bold;
    }

    .categories-row {
        display: flex;
        overflow-x: hidden;
        padding: 20px 0;
        position: relative;
    }

    .categories-row::-webkit-scrollbar {
        display: none;
    }

    .categories-row .category-card {
        flex: 0 0 auto;
        width: 300px;
        margin-right: 20px;
    }

    .scroll-button {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        background-color: #ff69b4;
        border: none;
        color: white;
        padding: 10px;
        cursor: pointer;
        z-index: 1;
    }

    .scroll-button-left {
        left: 0;
    }

    .scroll-button-right {
        right: 0;
    }

    .product-card {
        height: 100%;
        display: flex;
        flex-direction: column;
    }

    .product-card img {
        height: 200px;
        object-fit: cover;
    }

    .product-card .card-body {
        flex-grow: 1;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }
</style>

<div class="container">
    <!-- Search Bar -->
    <div class="row">
        <div class="col-md-12 search-bar">
            <form class="form-inline my-4" action="../function/search.php" method="GET">
                <input class="form-control mr-sm-2" type="search" name="query" placeholder="Search for products"
                    aria-label="Search">
                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
            </form>
        </div>
    </div>

    <!-- Welcome Title -->
    <h2 class="welcome-title">Welcome to Bianca Goods and Collection</h2>

    <!-- Categories Section -->
    <h3 class="welcome-title">Categories</h3>
    <button class="scroll-button scroll-button-left" onclick="scrollLeft()">&#9664;</button>
    <div class="categories-row" id="categoriesRow">
        <?php while ($category = $categories_result->fetch_assoc()): ?>
            <a href="categories.php?id=<?php echo $category['id']; ?>" class="text-decoration-none">
                <div class="card category-card">
                    <img src="<?php echo $category['image']; ?>" class="card-img" alt="<?php echo $category['name']; ?>" style="height: 200px; object-fit: cover;">
                    <div class="card-body d-flex flex-column justify-content-center align-items-start">
                        <h5 class="card-title"><?php echo $category['name']; ?></h5>
                    </div>
                </div>
            </a>
        <?php endwhile; ?>
    </div>
    <button class="scroll-button scroll-button-right" onclick="scrollRight()">&#9654;</button>

    <!-- Featured Products Cards -->
    <h3 class="welcome-title">Featured Products</h3>
    <div class="row">
        <?php while ($product = $featured_result->fetch_assoc()): ?>
            <div class="col-md-3 d-flex">
                <div class="card product-card">
                    <img src="<?php echo $product['product_image']; ?>" class="card-img-top"
                        alt="<?php echo $product['product_name']; ?>">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $product['product_name']; ?></h5>
                        <p class="card-text">₱<?php echo $product['product_price']; ?></p>
                        <a href="product.php?id=<?php echo $product['id']; ?>" class="btn btn-primary">View Product</a>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
</div>

<?php include 'footer.php'; ?>

<!-- Custom JavaScript -->
<script>
    function scrollLeft() {
        document.getElementById('categoriesRow').scrollBy({
            left: -300,
            behavior: 'smooth'
        });
    }

    function scrollRight() {
        document.getElementById('categoriesRow').scrollBy({
            left: 300,
            behavior: 'smooth'
        });
    }

    // Auto-scroll function
    function autoScroll() {
        const row = document.getElementById('categoriesRow');
        let scrollAmount = 0;
        const slideTimer = setInterval(() => {
            row.scrollBy({
                left: 1,
                behavior: 'smooth'
            });
            scrollAmount += 1;
            if (scrollAmount >= row.scrollWidth - row.clientWidth) {
                clearInterval(slideTimer);
                setTimeout(() => {
                    row.scrollTo({ left: 0, behavior: 'smooth' });
                    autoScroll();
                }, 2000);
            }
        }, 50);
    }

    // Start auto-scroll on page load
    window.onload = autoScroll;
</script>