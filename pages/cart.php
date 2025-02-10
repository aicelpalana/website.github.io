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

// Store cart items in an array
$cart_items = [];
while ($cart_item = $cart_result->fetch_assoc()) {
    $cart_items[] = $cart_item;
}
?>

<?php include 'header.php'; ?>

<!-- Custom CSS -->
<style>
    .cart-container {
        margin: 50px auto;
        max-width: 800px;
    }
    .cart-item {
        margin-bottom: 20px;
        border: 1px solid #ddd;
        border-radius: 10px;
        padding: 20px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        background-color: #f9f9f9;
    }
    .cart-item img {
        width: 100px;
        height: auto;
        border-radius: 10px;
    }
    .cart-item-details {
        margin-left: 20px;
    }
    .cart-item-title {
        font-size: 1.5em;
        color: #4a4a4a;
    }
    .cart-item-price {
        font-size: 1.2em;
        color: #5cb85c;
    }
    .cart-item-quantity {
        margin-top: 10px;
    }
    .btn-custom {
        background-color: #5cb85c;
        color: white;
    }
    .btn-custom:hover {
        background-color: #4cae4c;
    }
    .btn-danger {
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .btn-danger svg {
        margin-right: 5px;
    }
</style>

<div class="container cart-container">
    <h2 class="text-center">Your Cart</h2>
    <?php if (count($cart_items) > 0): ?>
        <?php foreach ($cart_items as $cart_item): ?>
            <div class="row cart-item">
                <div class="col-md-3">
                    <img src="<?php echo $cart_item['product_image']; ?>" alt="<?php echo $cart_item['product_name']; ?>">
                </div>
                <div class="col-md-6 cart-item-details">
                    <h5 class="cart-item-title"><?php echo $cart_item['product_name']; ?></h5>
                    <p class="cart-item-price">₱<?php echo $cart_item['product_price']; ?></p>
                    <p class="cart-item-quantity">Quantity: <?php echo $cart_item['quantity']; ?></p>
                </div>
                <div class="col-md-3">
                    <a href="../function/remove_to_cart.php?id=<?php echo $cart_item['cart_id']; ?>" class="btn btn-danger btn-block">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                            <path d="M5.5 5.5A.5.5 0 0 1 6 5h4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-.5.5H6a.5.5 0 0 1-.5-.5v-7zM4.118 4a1 1 0 0 1 .876-.5h6.012a1 1 0 0 1 .876.5H14.5a.5.5 0 0 1 0 1h-13a.5.5 0 0 1 0-1h1.618zM4.5 1a.5.5 0 0 1 .5-.5h6a.5.5 0 0 1 .5.5V2h-7V1zM3.5 3h9a.5.5 0 0 1 .5.5v.5h-10v-.5a.5.5 0 0 1 .5-.5z"/>
                        </svg>
                        Remove
                    </a>
                </div>
            </div>
        <?php endforeach; ?>
        <div class="text-center">
            <a href="checkout.php" class="btn btn-custom">Proceed to Checkout</a>
        </div>
    <?php else: ?>
        <p class="text-center text-danger">Your cart is empty. Please add items to your cart before proceeding to checkout.</p>
    <?php endif; ?>
</div>

<?php include 'footer.php'; ?>