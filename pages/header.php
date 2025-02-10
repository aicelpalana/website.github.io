<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bianca Goods and Collection</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <style>
        .navbar-custom {
            background-color: #ff69b4; /* Pinkish background color */
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* Subtle shadow for depth */
        }

        .navbar-custom .navbar-brand,
        .navbar-custom .nav-link {
            color: #ffffff; /* White text color */
            font-weight: bold; /* Bold text */
        }

        .navbar-custom .nav-link:hover {
            color: #ff1493; /* Darker pink on hover */
        }

        .navbar-custom .navbar-toggler {
            border-color: rgba(255, 255, 255, 0.1);
        }

        .navbar-custom .navbar-toggler-icon {
            background-image: url("data:image/svg+xml;charset=utf8,%3Csvg viewBox='0 0 30 30' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath stroke='rgba%28255, 255, 255, 0.5%29' stroke-width='2' stroke-linecap='round' stroke-miterlimit='10' d='M4 7h22M4 15h22M4 23h22'/%3E%3C/svg%3E");
        }

        .navbar-custom .nav-item {
            margin-left: 15px; /* Spacing between nav items */
        }
    </style>
</head>

<body>
    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-custom">
        <a class="navbar-brand" href="#">Bianca Goods and Collection</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <?php if (isset($_SESSION['username'])): ?>
                    <?php
                    // Check user type
                    $user_id = $_SESSION['id'];
                    $query = "SELECT type_id FROM user_type WHERE user_id = ?";
                    $stmt = $conn->prepare($query);
                    $stmt->bind_param('i', $user_id);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    $user_type = $result->fetch_assoc()['type_id'];
                    ?>
                    <?php if ($user_type == 2): // Seller ?>
                        <li class="nav-item">
                            <a class="nav-link" href="modify_products.php">Modify Products</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="manage_orders.php">Manage Orders</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="sales_report.php">Sales Report</a>
                        </li>
                    <?php else: // Customer ?>
                        <li class="nav-item">
                            <a class="nav-link" href="home.php">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="products.php">Products</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="cart.php">Cart</a>
                        </li>
                    <?php endif; ?>
                    <li class="nav-item">
                        <a class="nav-link" href="#"><?php echo $_SESSION['username']; ?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../function/logout.php">Logout</a>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link" href="../index.php">Login</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </nav>
</body>

</html>