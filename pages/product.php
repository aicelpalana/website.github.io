<?php
session_start();
require '../function/config.php'; // Include your database configuration file

// Get product ID from URL
$product_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Fetch product details
$product_query = "SELECT * FROM seller_products WHERE id = ?";
$stmt = $conn->prepare($product_query);
$stmt->bind_param('i', $product_id);
$stmt->execute();
$product_result = $stmt->get_result();
$product = $product_result->fetch_assoc();

// Fetch category name
$category_query = "SELECT name FROM categories WHERE id = ?";
$stmt = $conn->prepare($category_query);
$stmt->bind_param('i', $product['category_id']);
$stmt->execute();
$category_result = $stmt->get_result();
$category = $category_result->fetch_assoc();
?>

<?php include 'header.php'; ?>

<!-- Custom CSS -->
<style>
    .product-container {
        margin: 50px auto;
        max-width: 1000px;
        padding: 20px;
        border-radius: 15px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        background-color: #ffffff;
    }
    .product-image {
        width: 100%;
        height: auto;
        border-radius: 10px;
    }
    .product-details {
        margin-top: 20px;
    }
    .product-title {
        font-size: 2.5em;
        color: #ff69b4;
        font-weight: bold;
    }
    .product-price {
        font-size: 2em;
        color: #ff1493;
        margin-top: 10px;
    }
    .product-description {
        margin-top: 20px;
        font-size: 1.2em;
        color: #4a4a4a;
    }
    .btn-custom {
        background-color: #ff69b4;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 25px;
        transition: background-color 0.3s;
        margin-top: 20px;
    }
    .btn-custom:hover {
        background-color: #ff1493;
    }
    .product-meta {
        margin-top: 20px;
        font-size: 1em;
        color: #4a4a4a;
    }
    .product-meta span {
        font-weight: bold;
    }
    .related-products {
        margin-top: 50px;
    }
    .related-products h3 {
        color: #ff69b4;
        font-size: 2em;
        font-weight: bold;
        text-align: center;
        margin-bottom: 30px;
    }
    .related-product-card {
        margin: 15px;
        border: none;
        border-radius: 15px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        background-color: #ffffff;
        transition: transform 0.3s, box-shadow 0.3s;
        display: flex;
        flex-direction: column;
        height: 100%;
    }
    .related-product-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
    }
    .related-product-card img {
        border-top-left-radius: 15px;
        border-top-right-radius: 15px;
        height: 200px;
        object-fit: cover;
    }
    .related-product-card .card-body {
        text-align: center;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }
    .related-product-card .card-title {
        color: #ff69b4;
        font-size: 1.5em;
        font-weight: bold;
    }
    .related-product-card .card-text {
        color: #4a4a4a;
        font-size: 1.2em;
    }
    .related-product-card .btn-primary {
        background-color: #ff69b4;
        border: none;
        transition: background-color 0.3s;
    }
    .related-product-card .btn-primary:hover {
        background-color: #ff1493;
    }
</style>

<div class="container product-container">
    <div class="row">
        <div class="col-md-6">
            <img src="<?php echo $product['product_image']; ?>" class="product-image" alt="<?php echo $product['product_name']; ?>">
        </div>
        <div class="col-md-6 product-details">
            <h2 class="product-title"><?php echo $product['product_name']; ?></h2>
            <p class="product-price">₱<?php echo $product['product_price']; ?></p>
            <p class="product-description"><?php echo $product['product_description']; ?></p>
            <a href="../function/add_to_cart.php?id=<?php echo $product['id']; ?>" class="btn btn-custom btn-block">Add to Cart</a>
            <div class="product-meta">
                <p><span>Category:</span> <?php echo $category['name']; ?></p>
            </div>
        </div>
    </div>
</div>

<!-- Related Products Section -->
<div class="container related-products">
    <h3>Related Products</h3>
    <div class="row">
        <?php
        // Fetch related products (randomly picked)
        $related_query = "SELECT * FROM seller_products WHERE category_id = ? AND id != ? ORDER BY RAND() LIMIT 4";
        $stmt = $conn->prepare($related_query);
        $stmt->bind_param('ii', $product['category_id'], $product_id);
        $stmt->execute();
        $related_result = $stmt->get_result();
        while ($related_product = $related_result->fetch_assoc()): ?>
            <div class="col-md-3 d-flex">
                <div class="card related-product-card">
                    <img src="<?php echo $related_product['product_image']; ?>" class="card-img-top" alt="<?php echo $related_product['product_name']; ?>">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $related_product['product_name']; ?></h5>
                        <p class="card-text">₱<?php echo $related_product['product_price']; ?></p>
                        <a href="product.php?id=<?php echo $related_product['id']; ?>" class="btn btn-primary">View Product</a>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
</div>

<?php include 'footer.php'; ?>