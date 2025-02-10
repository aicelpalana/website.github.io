<?php
session_start();
require '../function/config.php'; // Include your database configuration file
?>

<?php include 'header.php'; ?>

<!-- Custom CSS -->
<style>
    .dashboard-container {
        max-width: 800px;
        margin: 50px auto;
        padding: 20px;
        text-align: center;
    }
    .card {
        display: inline-block;
        width: 200px;
        margin: 20px;
        padding: 20px;
        border: 1px solid #ddd;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        background-color: #f9f9f9;
        text-decoration: none;
        color: inherit;
    }
    .card:hover {
        box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
    }
    .card svg {
        width: 50px;
        height: 50px;
        margin-bottom: 10px;
    }
    .card-title {
        font-size: 18px;
        font-weight: bold;
        color: #4a4a4a;
    }
</style>

<div class="container">
    <div class="dashboard-container">
        <a href="modify_products.php" class="card">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            <div class="card-title">Modify Products</div>
        </a>
        <a href="manage_orders.php" class="card">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h18M3 7h18M3 11h18M3 15h18M3 19h18" />
            </svg>
            <div class="card-title">Manage Orders</div>
        </a>
        <a href="sales_report.php" class="card">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h18M3 7h18M3 11h18M3 15h18M3 19h18" />
            </svg>
            <div class="card-title">Sales Report</div>
        </a>
    </div>
</div>

<?php include 'footer.php'; ?>