<?php
session_start();
require 'config.php'; // Include your database configuration file

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $order_id = $_POST['order_id'];
    $status = $_POST['status'];

    // Update order status in the orders table
    $query = "UPDATE orders SET status = ? WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('si', $status, $order_id);
    $stmt->execute();

    header('Location: manage_orders.php'); // Redirect back to manage orders page
    exit();
}
?>