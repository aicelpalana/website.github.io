<?php
session_start();
require '../function/config.php'; // Include your database configuration file

// Get category ID from URL
$category_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Fetch category details
$category_query = "SELECT * FROM categories WHERE id = ?";
$stmt = $conn->prepare($category_query);
$stmt->bind_param('i', $category_id);
$stmt->execute();
$category_result = $stmt->get_result();
$category = $category_result->fetch_assoc();

// Fetch products in the category
$products_query = "SELECT * FROM seller_products WHERE category_id = ?";
$stmt = $conn->prepare($products_query);
$stmt->bind_param('i', $category_id);
$stmt->execute();
$products_result = $stmt->get_result();
?>



<?php include 'header.php'; ?>

<!-- Custom CSS -->
<style>
    .category-title {
        margin: 20px 0;
        text-align: center;
        color: #4a4a4a;
    }
    .product-card {
        margin: 15px;
        border: 1px solid #ddd;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        background-color: #f9f9f9;
    }
    .product-card img {
        border-top-left-radius: 10px;
        border-top-right-radius: 10px;
        height: 200px;
        object-fit: cover;
    }
    .product-card .card-body {
        text-align: center;
    }
</style>

<div class="container">
    <!-- Category Title -->
    <h2 class="category-title"><?php echo $category['name']; ?></h2>

    <!-- Products in Category -->
    <div class="row">
        <?php while ($product = $products_result->fetch_assoc()): ?>
            <div class="col-md-3">
                <div class="card product-card">
                <img src="<?php echo $product['product_image']; ?>" class="card-img-top" alt="Product Image">

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