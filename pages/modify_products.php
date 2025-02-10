<?php
session_start();
require '../function/config.php'; // Include your database configuration file

// Fetch products for the logged-in seller
$seller_id = $_SESSION['id'];
$query = "SELECT * FROM seller_products WHERE seller_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('i', $seller_id);
$stmt->execute();
$products_result = $stmt->get_result();
?>

<?php include 'header.php'; ?>

<!-- Custom CSS -->
<style>
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
    }

    .product-card .card-body {
        text-align: center;
    }

    .product-card a {
        text-decoration: none;
        color: inherit;
    }
</style>

<div class="container">
    <h2 class="welcome-title">Modify Products</h2>
    <button class="btn btn-primary mb-4" data-toggle="modal" data-target="#addProductModal">Add Product</button>
    <div class="row">
        <?php while ($product = $products_result->fetch_assoc()): ?>
            <div class="col-md-3">
                <div class="card product-card">
                    <img src="<?php echo $product['product_image']; ?>" class="card-img-top" alt="<?php echo $product['product_name']; ?>" style="height: 200px; object-fit: cover;">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $product['product_name']; ?></h5>
                        <p class="card-text">₱<?php echo $product['product_price']; ?></p>
                        <button class="btn btn-warning" data-toggle="modal" data-target="#editProductModal" data-id="<?php echo $product['id']; ?>" data-name="<?php echo $product['product_name']; ?>" data-price="<?php echo $product['product_price']; ?>" data-description="<?php echo $product['product_description']; ?>" data-image="<?php echo $product['product_image']; ?>">Edit</button>
                        <button class="btn btn-danger" data-toggle="modal" data-target="#deleteProductModal" data-id="<?php echo $product['id']; ?>">Delete</button>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
</div>

<!-- Add Product Modal -->
<div class="modal fade" id="addProductModal" tabindex="-1" role="dialog" aria-labelledby="addProductModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="POST" action="../function/add_product.php" enctype="multipart/form-data">
                <div class="modal-header">
                    <h5 class="modal-title" id="addProductModalLabel">Add Product</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="product_name">Product Name</label>
                        <input type="text" class="form-control" id="product_name" name="product_name" required>
                    </div>
                    <div class="form-group">
                        <label for="product_price">Product Price ₱</label>
                        <input type="number" class="form-control" id="product_price" name="product_price" required>
                    </div>
                    <div class="form-group">
                        <label for="product_description">Product Description</label>
                        <textarea class="form-control" id="product_description" name="product_description" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="product_image">Product Image</label>
                        <input type="file" class="form-control" id="product_image" name="product_image" required>
                    </div>
                    <div class="form-group">
                        <label for="category_id">Category</label>
                        <select class="form-control" id="category_id" name="category_id" required>
                            <?php
                            $categories_query = "SELECT * FROM categories";
                            $categories_result = $conn->query($categories_query);
                            while ($category = $categories_result->fetch_assoc()) {
                                echo '<option value="' . $category['id'] . '">' . $category['name'] . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Add Product</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Product Modal -->
<div class="modal fade" id="editProductModal" tabindex="-1" role="dialog" aria-labelledby="editProductModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="POST" action="../function/edit_product.php" enctype="multipart/form-data">
                <div class="modal-header">
                    <h5 class="modal-title" id="editProductModalLabel">Edit Product</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="edit_product_id" name="product_id">
                    <div class="form-group">
                        <label for="edit_product_name">Product Name</label>
                        <input type="text" class="form-control" id="edit_product_name" name="product_name" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_product_price">Product Price ₱</label>
                        <input type="number" class="form-control" id="edit_product_price" name="product_price" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_product_description">Product Description</label>
                        <textarea class="form-control" id="edit_product_description" name="product_description" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="edit_product_image">Product Image</label>
                        <input type="file" class="form-control" id="edit_product_image" name="product_image">
                    </div>
                    <div class="form-group">
                        <label for="edit_category_id">Category</label>
                        <select class="form-control" id="edit_category_id" name="category_id" required>
                            <?php
                            $categories_query = "SELECT * FROM categories";
                            $categories_result = $conn->query($categories_query);
                            while ($category = $categories_result->fetch_assoc()) {
                                echo '<option value="' . $category['id'] . '">' . $category['name'] . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Product Modal -->
<div class="modal fade" id="deleteProductModal" tabindex="-1" role="dialog" aria-labelledby="deleteProductModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="POST" action="../function/delete_product.php">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteProductModalLabel">Delete Product</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="delete_product_id" name="product_id">
                    <p>Are you sure you want to delete this product?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger">Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Include jQuery -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<!-- Include Bootstrap JS -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
    $('#editProductModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var id = button.data('id');
        var name = button.data('name');
        var price = button.data('price');
        var description = button.data('description');
        var image = button.data('image');

        var modal = $(this);
        modal.find('#edit_product_id').val(id);
        modal.find('#edit_product_name').val(name);
        modal.find('#edit_product_price').val(price);
        modal.find('#edit_product_description').val(description);
        modal.find('#edit_product_image').val(image);
    });

    $('#deleteProductModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var id = button.data('id');

        var modal = $(this);
        modal.find('#delete_product_id').val(id);
    });
</script>

<?php include 'footer.php'; ?>