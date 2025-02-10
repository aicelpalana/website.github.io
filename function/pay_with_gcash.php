<?php
session_start();
require '../function/config.php'; // Include your database configuration file
require '../vendor/autoload.php'; // Include the Guzzle HTTP client

use GuzzleHttp\Client;

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

// PayMongo API credentials
$api_key = 'sk_test_hzvp5pnbhtD6kqSdF21cqNrP';
$encoded_api_key = base64_encode($api_key . ':');

try {
    $client = new Client();

    // Create a checkout session
    $response = $client->request('POST', 'https://api.paymongo.com/v1/checkout_sessions', [
        'body' => json_encode([
            'data' => [
                'attributes' => [
                    'send_email_receipt' => false,
                    'show_description' => false,
                    'show_line_items' => true,
                    'line_items' => [
                        [
                            'currency' => 'PHP',
                            'amount' => $total_amount * 100, // Amount in centavos
                            'description' => 'E-commerce Store Purchase',
                            'name' => 'Product',
                            'quantity' => 1
                        ]
                    ],
                    'payment_method_types' => ['gcash'],
                    'success_url' => 'http://localhost/order/pages/successful.php'
                ]
            ]
        ]),
        'headers' => [
            'Content-Type' => 'application/json',
            'accept' => 'application/json',
            'authorization' => 'Basic ' . $encoded_api_key,
        ],
    ]);

    $responseBody = json_decode($response->getBody(), true);

    // Redirect to GCash payment page
    if (isset($responseBody['data']['attributes']['checkout_url'])) {
        header('Location: ' . $responseBody['data']['attributes']['checkout_url']);
        exit();
    } else {
        echo 'Payment failed. Please try again.';
    }
} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage();
}
?>