<?php
session_start();
require 'function/config.php'; // Include your database configuration file

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Query to check if the user exists
    $query = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        // Verify password
       // Directly compare passwords since they are stored in plain text
if ($password === $user['password']) {

            $_SESSION['id'] = $user['id'];
            $_SESSION['username'] = $user['username'];

            // Query to get the user type
            $query = "SELECT type_id FROM user_type WHERE user_id = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param('i', $user['id']);
            $stmt->execute();
            $result = $stmt->get_result();
            $user_type = $result->fetch_assoc();

            if ($user_type['type_id'] == 1) {
                header('Location: pages/home.php'); // Redirect to home for customers
            } elseif ($user_type['type_id'] == 2) {
                header('Location: pages/dashboard.php'); // Redirect to dashboard for sellers
            }
            exit();
        } else {
            $error = "Invalid password.";
        }
    } else {
        $error = "No user found with that username.";
    }
}
?>

<?php include 'pages/header.php'; ?>

<!-- Custom CSS -->
<style>
    .login-container {
        max-width: 400px;
        margin: 50px auto;
        padding: 30px;
        border-radius: 15px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        background-color: #ffffff;
    }
    .login-container h2 {
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
    .register-link {
        display: block;
        margin-top: 10px;
        text-align: center;
        color: #ff69b4;
    }
    .register-link:hover {
        color: #ff1493;
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
    <div class="login-container">
        <h2>Login</h2>
        <?php if (isset($error)): ?>
            <div class="alert alert-danger" role="alert">
                <?php echo $error; ?>
            </div>
        <?php endif; ?>
        <form method="POST" action="">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <div class="form-group">
    <label for="password">Password:</label>
    <div class="input-group">
        <input type="password" class="form-control" id="password" name="password" required>
        <div class="input-group-append">
            <button type="button" class="btn btn-outline-secondary" id="togglePassword">
                <i class="fa fa-eye"></i>
            </button>
        </div>
    </div>
</div>

<script>
    document.getElementById("togglePassword").addEventListener("click", function () {
        let passwordField = document.getElementById("password");
        let icon = this.querySelector("i");

        if (passwordField.type === "password") {
            passwordField.type = "text";
            icon.classList.remove("fa-eye");
            icon.classList.add("fa-eye-slash");
        } else {
            passwordField.type = "password";
            icon.classList.remove("fa-eye-slash");
            icon.classList.add("fa-eye");
        }
    });
</script>
            <button type="submit" class="btn btn-custom btn-block">Login</button>
            <a href="pages/register.php" class="register-link">Don't have an account? Register here</a>
            <a href="pages/forgot_password.php" class="register-link">Forgot your password?</a>

        </form>
    </div>
</div>


<?php include 'pages/footer.php'; ?>