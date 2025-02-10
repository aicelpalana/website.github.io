<?php
session_start();
require '../function/config.php'; // Include your database configuration file

// Fetch all products sorted randomly
$products_query = "SELECT * FROM seller_products ORDER BY RAND()";
$products_result = $conn->query($products_query);
?>

<?php include 'header.php'; ?>

<!-- Custom CSS -->
<style>
    .products-container {
        margin: 50px auto;
        max-width: 1200px;
    }
    .product-card {
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
    .product-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
    }
    .product-card img {
        border-top-left-radius: 15px;
        border-top-right-radius: 15px;
        height: 200px;
        object-fit: cover;
    }
    .product-card .card-body {
        text-align: center;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }
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
    .product-card .btn-success {
        background-color: #28a745;
        border: none;
        transition: background-color 0.3s;
    }
    .product-card .btn-success:hover {
        background-color: #218838;
    }
</style>

<div class="container products-container">
    <h2 class="text-center">All Products</h2>
    <div class="row">
        <?php while ($product = $products_result->fetch_assoc()): ?>
            <div class="col-md-3 d-flex">
                <div class="card product-card">
                    <img src="<?php echo $product['product_image']; ?>" class="card-img-top" alt="<?php echo $product['product_name']; ?>">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $product['product_name']; ?></h5>
                        <p class="card-text">₱<?php echo $product['product_price']; ?></p>
                        <a href="product.php?id=<?php echo $product['id']; ?>" class="btn btn-primary">View Product</a>
                        <a href="add_to_cart.php?id=<?php echo $product['id']; ?>" class="btn btn-success">Add to Cart</a>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
</div>

<?php include 'footer.php'; ?>