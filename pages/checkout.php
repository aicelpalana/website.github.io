<?php
session_start();
require '../function/config.php'; // Include your database configuration file

// Fetch cart items for the logged-in user
$user_id = $_SESSION['id'];
$cart_query = "SELECT cart.id as cart_id, seller_products.id as product_id, seller_products.product_name, seller_products.product_price, seller_products.product_image, cart.quantity 
               FROM cart 
               JOIN seller_products ON cart.product_id = seller_products.id 
               WHERE cart.user_id = ?";
$stmt = $conn->prepare($cart_query);
$stmt->bind_param('i', $user_id);
$stmt->execute();
$cart_result = $stmt->get_result();

// Calculate total amount
$total_amount = 0;
$cart_items = [];
while ($cart_item = $cart_result->fetch_assoc()) {
    $total_amount += $cart_item['product_price'] * $cart_item['quantity'];
    $cart_items[] = $cart_item;
}

// Convert total amount to centavos
$total_amount_centavos = $total_amount * 100;
?>

<?php include 'header.php'; ?>

<!-- Custom CSS -->
<style>
    .checkout-container {
        margin: 50px auto;
        max-width: 800px;
    }
    .checkout-item {
        margin-bottom: 20px;
        border: 1px solid #ddd;
        border-radius: 10px;
        padding: 20px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        background-color: #f9f9f9;
    }
    .checkout-item img {
        width: 100px;
        height: auto;
        border-radius: 10px;
    }
    .checkout-item-details {
        margin-left: 20px;
    }
    .checkout-item-title {
        font-size: 1.5em;
        color: #4a4a4a;
    }
    .checkout-item-price {
        font-size: 1.2em;
        color: #5cb85c;
    }
    .checkout-item-quantity {
        margin-top: 10px;
    }
    .btn-gcash {
        background-color: #007bff;
        color: white;
    }
    .btn-gcash:hover {
        background-color: #0056b3;
    }
</style>

<div class="container checkout-container">
    <h2 class="text-center">Checkout</h2>
    <?php foreach ($cart_items as $cart_item): ?>
        <div class="row checkout-item">
            <div class="col-md-3">
                <img src="<?php echo $cart_item['product_image']; ?>" alt="<?php echo $cart_item['product_name']; ?>">
            </div>
            <div class="col-md-6 checkout-item-details">
                <h5 class="checkout-item-title"><?php echo $cart_item['product_name']; ?></h5>
                <p class="checkout-item-price">₱<?php echo $cart_item['product_price']; ?></p>
                <p class="checkout-item-quantity">Quantity: <?php echo $cart_item['quantity']; ?></p>
            </div>
        </div>
    <?php endforeach; ?>
    <div class="text-center">
        <?php if (count($cart_items) > 0): ?>
            <?php if ($total_amount_centavos < 2000): ?>
                <p class="text-danger">The total amount must be at least ₱20.00 to proceed with the payment.</p>
            <?php else: ?>
                <a href="../function/pay_with_gcash.php" class="btn btn-gcash btn-block">Pay with GCash</a>
            <?php endif; ?>
        <?php else: ?>
            <p class="text-danger">Your cart is empty. Please add items to your cart before proceeding to checkout.</p>
        <?php endif; ?>
    </div>
</div>

<?php include 'footer.php'; ?>