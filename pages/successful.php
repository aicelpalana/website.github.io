<?php
session_start();
require '../function/config.php'; // Include your database configuration file

// Fetch cart items for the logged-in user
$user_id = $_SESSION['id'];
$cart_query = "SELECT cart.id as cart_id, seller_products.id as product_id, seller_products.product_name, seller_products.product_price, seller_products.product_image, cart.quantity, seller_products.seller_id 
               FROM cart 
               JOIN seller_products ON cart.product_id = seller_products.id 
               WHERE cart.user_id = ?";
$stmt = $conn->prepare($cart_query);
$stmt->bind_param('i', $user_id);
$stmt->execute();
$cart_result = $stmt->get_result();

// Insert order into the orders table
while ($cart_item = $cart_result->fetch_assoc()) {
    $order_query = "INSERT INTO orders (user_id, product_id, quantity, total_price, status, ordered_at, seller_id) VALUES (?, ?, ?, ?, 'Pending', NOW(), ?)";
    $stmt = $conn->prepare($order_query);
    $total_price = $cart_item['product_price'] * $cart_item['quantity'];
    $stmt->bind_param('iiidi', $user_id, $cart_item['product_id'], $cart_item['quantity'], $total_price, $cart_item['seller_id']);
    $stmt->execute();
}

// Clear the user's cart
$clear_cart_query = "DELETE FROM cart WHERE user_id = ?";
$stmt = $conn->prepare($clear_cart_query);
$stmt->bind_param('i', $user_id);
$stmt->execute();
?>

<?php include 'header.php'; ?>

<!-- Custom CSS -->
<style>
    .success-container {
        margin: 50px auto;
        max-width: 600px;
        text-align: center;
    }
    .success-message {
        font-size: 2em;
        color: #4a4a4a;
        margin-bottom: 20px;
    }
    .success-icon {
        font-size: 5em;
        color: #5cb85c;
        margin-bottom: 20px;
    }
    .btn-home {
        background-color: #5cb85c;
        color: white;
    }
    .btn-home:hover {
        background-color: #4cae4c;
    }
</style>

<div class="container success-container">
    <div class="success-icon">
        <i class="fas fa-check-circle"></i>
    </div>
    <div class="success-message">
        Your purchase was successful!
    </div>
    <a href="home.php" class="btn btn-home">Return to Home</a>
</div>

<?php include 'footer.php'; ?>