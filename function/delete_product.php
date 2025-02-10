<?php
session_start();
require '../function/config.php'; // Include your database configuration file

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $product_id = $_POST['product_id'];

    // Delete related entries from the cart table
    $cart_query = "DELETE FROM cart WHERE product_id = ?";
    $stmt = $conn->prepare($cart_query);
    $stmt->bind_param('i', $product_id);
    $stmt->execute();

    // Delete product from the seller_products table
    $product_query = "DELETE FROM seller_products WHERE id = ?";
    $stmt = $conn->prepare($product_query);
    $stmt->bind_param('i', $product_id);
    $stmt->execute();

    header('Location: ../pages/modify_products.php'); // Redirect back to modify products page
    exit();
}
?>