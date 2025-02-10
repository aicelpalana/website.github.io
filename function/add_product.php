<?php
session_start();
require '../function/config.php'; // Include your database configuration file

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $seller_id = $_SESSION['id'];
    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];
    $product_description = $_POST['product_description'];
    $category_id = $_POST['category_id'];

    // Handle file upload
    $product_image = $_FILES['product_image']['name'];
    $target_dir = "../pages/images/";
    $target_file = $target_dir . basename($product_image);
    move_uploaded_file($_FILES['product_image']['tmp_name'], $target_file);

    // Insert product into the seller_products table
    $query = "INSERT INTO seller_products (seller_id, product_name, product_price, product_description, product_image, category_id) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('issssi', $seller_id, $product_name, $product_price, $product_description, $target_file, $category_id);
    $stmt->execute();

    header('Location: ../pages/modify_products.php'); // Redirect back to modify products page
    exit();
}
?>