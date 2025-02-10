<?php
session_start();
require 'config.php'; // Include your database configuration file

// Get cart item ID from URL
$cart_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Delete the cart item
$delete_query = "DELETE FROM cart WHERE id = ?";
$stmt = $conn->prepare($delete_query);
$stmt->bind_param('i', $cart_id);
$stmt->execute();

header('Location: ../pages/cart.php');
exit();
?>