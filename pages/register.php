<?php
require '../function/config.php'; // Include your database configuration file

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $type_id = $_POST['type_id'];

   // Check if the username already exists
$query = "SELECT id FROM users WHERE username = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('s', $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    die("Error: Username already exists.");
}

// Insert user into the users table
$query = "INSERT INTO users (username, password) VALUES (?, ?)";
$stmt = $conn->prepare($query);
$stmt->bind_param('ss', $username, $password);
$stmt->execute();

$user_id = $stmt->insert_id;


    // Insert user type into the user_type table
    $query = "INSERT INTO user_type (user_id, type_id) VALUES (?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('ii', $user_id, $type_id);
    $stmt->execute();

    header('Location: ../index.php'); // Redirect to login page
    exit();
}
?>

<?php include '../pages/header.php'; ?>

<!-- Custom CSS -->
<style>
    .register-container {
        max-width: 400px;
        margin: 50px auto;
        padding: 30px;
        border-radius: 15px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        background-color: #ffffff;
    }
    .register-container h2 {
        margin-bottom: 20px;
        color: #ff69b4;
        font-size: 2em;
        font-weight: bold;
        text-align: center;
    }
    .btn-custom {
        background-color: #ff69b4;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 25px;
        transition: background-color 0.3s;
    }
    .btn-custom:hover {
        background-color: #ff1493;
    }
    .form-control {
        border-radius: 25px;
        padding: 10px;
        border: 1px solid #ddd;
        transition: box-shadow 0.3s;
    }
    .form-control:focus {
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        outline: none;
    }
    .alert {
        border-radius: 25px;
    }
</style>

<div class="container">
    <div class="register-container">
        <h2>Register</h2>
        <form method="POST" action="">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <div class="form-group">
                <label for="type_id">User Type:</label>
                <select class="form-control" id="type_id" name="type_id" required>
                    <option value="1">Customer</option>
                    <option value="2">Seller</option>
                </select>
            </div>
            <button type="submit" class="btn btn-custom btn-block">Register</button>
        </form>
    </div>
</div>

<?php include '../pages/footer.php'; ?>