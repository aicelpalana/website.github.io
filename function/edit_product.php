<?php
session_start();
require '../function/config.php'; // Include your database configuration file

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $product_id = $_POST['product_id'];
    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];
    $product_description = $_POST['product_description'];
    $category_id = $_POST['category_id'];

    // Handle file upload if a new image is provided
    if (!empty($_FILES['product_image']['name'])) {
        $product_image = $_FILES['product_image']['name'];
        $target_dir = "../uploads/";
        $target_file = $target_dir . basename($product_image);
        move_uploaded_file($_FILES['product_image']['tmp_name'], $target_file);

        // Update product with new image
        $query = "UPDATE seller_products SET product_name = ?, product_price = ?, product_description = ?, product_image = ?, category_id = ? WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('ssssii', $product_name, $product_price, $product_description, $target_file, $category_id, $product_id);
    } else {
        // Update product without changing the image
        $query = "UPDATE seller_products SET product_name = ?, product_price = ?, product_description = ?, category_id = ? WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('sssii', $product_name, $product_price, $product_description, $category_id, $product_id);
    }
    $stmt->execute();

    header('Location: ../pages/modify_products.php'); // Redirect back to modify products page
    exit();
}
?>