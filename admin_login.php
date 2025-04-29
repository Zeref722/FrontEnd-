<?php

include 'head.php'; 

if (isset($_POST['login'])) {
    $username = mysqli_real_escape_string($con, $_POST['username']);
    $password = mysqli_real_escape_string($con, $_POST['password']);
    
    
    if ($username === 'admin' && $password === 'admin123') {
        $_SESSION['admin_logged_in'] = true;
        header('Location: admin_panel.php');
        exit();
    } else {
        echo "<script>alert('Invalid credentials');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #000; color: #fff; font-family: Arial, sans-serif; }
        .login-container { display: flex; justify-content: center; align-items: center; height: 100vh; }
        .login-form { width: 100%; max-width: 400px; background: rgba(0, 0, 0, 0.8); padding: 20px; border-radius: 10px; }
        .btn-primary { background-color: #ff6600; border-color: #ff6600; }
        .btn-primary:hover { background-color: #e65c00; border-color: #e65c00; }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-form">
            <h2 class="text-center mb-4">Admin Login</h2>
            <form method="POST">
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" name="username" class="form-control" id="username" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" id="password" required>
                </div>
                <button type="submit" name="login" class="btn btn-primary w-100">Login</button>
            </form>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>