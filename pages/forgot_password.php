<?php
session_start();
require 'function/config.php'; // Database connection

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];

    // Check if the email exists in the database
    $query = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $token = bin2hex(random_bytes(50)); // Generate secure token
        $expires = date("Y-m-d H:i:s", strtotime('+1 hour')); // Token expires in 1 hour

        // Store the reset token in the database
        $insert = "INSERT INTO password_resets (email, token, expires_at) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($insert);
        $stmt->bind_param('sss', $email, $token, $expires);
        $stmt->execute();

        // Send password reset email
        $reset_link = "http://yourwebsite.com/reset_password.php?token=$token";
        $subject = "Password Reset Request";
        $message = "Click the following link to reset your password: $reset_link";
        $headers = "From: no-reply@yourwebsite.com\r\n";
        
        if (mail($email, $subject, $message, $headers)) {
            $success = "A password reset link has been sent to your email.";
        } else {
            $error = "Failed to send email. Try again later.";
        }
    } else {
        $error = "No account found with that email.";
    }
}
?>

<?php include 'pages/header.php'; ?>

<style>
    .reset-container {
        max-width: 400px;
        margin: 50px auto;
        padding: 30px;
        border-radius: 15px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        background-color: #ffffff;
    }
    .reset-container h2 {
        text-align: center;
        color: #ff69b4;
    }
    .btn-custom {
        background-color: #ff69b4;
        color: white;
        border-radius: 25px;
    }
</style>

<div class="container">
    <div class="reset-container">
        <h2>Forgot Password</h2>
        <?php if (isset($success)): ?>
            <div class="alert alert-success"><?php echo $success; ?></div>
        <?php elseif (isset($error)): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>
        <form method="POST" action="">
            <div class="form-group">
                <label for="email">Enter your email:</label>
                <input type="email" class="form-control" name="email" required>
            </div>
            <button type="submit" class="btn btn-custom btn-block">Send Reset Link</button>
        </form>
    </div>
</div>

<?php include 'pages/footer.php'; ?>
                