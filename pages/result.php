<?php
session_start();
require '../function/config.php'; // Include your database configuration file

$search_query = isset($_GET['query']) ? $_GET['query'] : '';

$search_sql = "SELECT * FROM seller_products WHERE product_name LIKE ? OR product_description LIKE ?";
$stmt = $conn->prepare($search_sql);
$search_term = '%' . $search_query . '%';
$stmt->bind_param('ss', $search_term, $search_term);
$stmt->execute();
$search_result = $stmt->get_result();
?>

<?php include 'header.php'; ?>

<div class="container">
    <h2 class="welcome-title">Search Results for "<?php echo htmlspecialchars($search_query); ?>"</h2>
    <div class="row">
        <?php if ($search_result->num_rows > 0): ?>
            <?php while ($product = $search_result->fetch_assoc()): ?>
                <div class="col-md-3">
                    <div class="card product-card">
                        <img 
                            src="<?php echo $product['product_image']; ?>" 
                            class="card-img-top" 
                            alt="<?php echo $product['product_name']; ?>" 
                            style="height: 200px; object-fit: cover;"
                        >
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $product['product_name']; ?></h5>
                            <p class="card-text">₱<?php echo $product['product_price']; ?></p>
                            <a href="product.php?id=<?php echo $product['id']; ?>" class="btn btn-primary">View Product</a>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>No products found matching your search criteria.</p>
        <?php endif; ?>
    </div>
</div>

<?php include 'footer.php'; ?>