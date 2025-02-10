<?php
session_start();
require 'config.php'; // Include your database configuration file

// Get product ID from URL
$product_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$user_id = $_SESSION['id'];

// Check if the product exists in the seller_products table
$product_check_query = "SELECT * FROM seller_products WHERE id = ?";
$stmt = $conn->prepare($product_check_query);
$stmt->bind_param('i', $product_id);
$stmt->execute();
$product_check_result = $stmt->get_result();

if ($product_check_result->num_rows > 0) {
    // Check if the product is already in the cart
    $check_query = "SELECT * FROM cart WHERE user_id = ? AND product_id = ?";
    $stmt = $conn->prepare($check_query);
    $stmt->bind_param('ii', $user_id, $product_id);
    $stmt->execute();
    $check_result = $stmt->get_result();

    if ($check_result->num_rows > 0) {
        // If the product is already in the cart, update the quantity
        $update_query = "UPDATE cart SET quantity = quantity + 1 WHERE user_id = ? AND product_id = ?";
        $stmt = $conn->prepare($update_query);
        $stmt->bind_param('ii', $user_id, $product_id);
        $stmt->execute();
    } else {
        // If the product is not in the cart, insert a new record
        $insert_query = "INSERT INTO cart (user_id, product_id, quantity) VALUES (?, ?, 1)";
        $stmt = $conn->prepare($insert_query);
        $stmt->bind_param('ii', $user_id, $product_id);
        $stmt->execute();
    }
}

header('Location: ../pages/cart.php');
exit();
?>