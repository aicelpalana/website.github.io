<?php
session_start();
require '../function/config.php'; // Include your database configuration file

// Fetch orders for the logged-in seller
$seller_id = $_SESSION['id'];
$query = "SELECT orders.id, orders.user_id, orders.product_id, orders.quantity, orders.total_price, orders.status, orders.ordered_at, users.username, seller_products.product_name 
          FROM orders 
          JOIN users ON orders.user_id = users.id 
          JOIN seller_products ON orders.product_id = seller_products.id 
          WHERE orders.seller_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('i', $seller_id);
$stmt->execute();
$orders_result = $stmt->get_result();
?>

<?php include 'header.php'; ?>

<!-- Custom CSS -->
<style>
    .order-card {
        margin: 15px;
        border: 1px solid #ddd;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        background-color: #f9f9f9;
        padding: 20px;
    }

    .order-card h5 {
        margin-bottom: 15px;
    }

    .order-card p {
        margin-bottom: 10px;
    }

    .order-card select {
        margin-bottom: 10px;
    }
</style>

<div class="container">
    <h2 class="welcome-title">Manage Orders</h2>
    <div class="row">
        <?php while ($order = $orders_result->fetch_assoc()): ?>
            <div class="col-md-4">
                <div class="card order-card">
                    <h5>Order #<?php echo $order['id']; ?></h5>
                    <p><strong>Customer:</strong> <?php echo $order['username']; ?></p>
                    <p><strong>Product:</strong> <?php echo $order['product_name']; ?></p>
                    <p><strong>Quantity:</strong> <?php echo $order['quantity']; ?></p>
                    <p><strong>Total Price:</strong> ₱<?php echo $order['total_price']; ?></p>
                    <p><strong>Ordered At:</strong> <?php echo $order['ordered_at']; ?></p>
                    <form method="POST" action="../function/update_order_status.php">
                        <input type="hidden" name="order_id" value="<?php echo $order['id']; ?>">
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select class="form-control" id="status" name="status" required>
                                <option value="Packaged" <?php if ($order['status'] == 'Packaged') echo 'selected'; ?>>Packaged</option>
                                <option value="Shipping" <?php if ($order['status'] == 'Shipping') echo 'selected'; ?>>Shipping</option>
                                <option value="Out for Delivery" <?php if ($order['status'] == 'Out for Delivery') echo 'selected'; ?>>Out for Delivery</option>
                                <option value="Delivered" <?php if ($order['status'] == 'Delivered') echo 'selected'; ?>>Delivered</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Update Status</button>
                    </form>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
</div>

<?php include 'footer.php'; ?>