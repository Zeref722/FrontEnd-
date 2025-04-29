<?php
include 'head.php';

if (isset($_POST['sub'])) {
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $password = mysqli_real_escape_string($con, $_POST['password']);
    
    $stmt = $con->prepare("SELECT id, name FROM gym_membership WHERE email = ? AND password = ?");
    $stmt->bind_param("ss", $email, $password);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $_SESSION['user_id'] = $row['id'];
        $_SESSION['name'] = $row['name'];
        echo "<script>window.location.href = 'PKG.php';</script>";
    } else {
        echo "<script>alert('Invalid Credentials');</script>";
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { margin: 0; padding: 0; background: #000; color: #fff; font-family: Arial, sans-serif; }
        .login-container { display: flex; height: 100vh; }
        .image-section { flex: 1; background: url('css/24910604184786044.jpeg') no-repeat center center/cover; }
        .form-section { flex: 1; display: flex; justify-content: center; align-items: center; background: rgba(0, 0, 0, 0.8); }
        .login-form { width: 100%; max-width: 400px; }
        .login-logo { text-align: center; margin-bottom: 30px; }
        .login-logo img { width: 100px; }
        .btn-primary { background-color: #ff6600; border-color: #ff6600; }
        .btn-primary:hover { background-color: #e65c00; border-color: #e65c00; }
        a { color: #ff6600; }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="image-section"></div>
        <div class="form-section">
            <div class="login-form">
                <div class="login-logo">
                    <img src="css/PRO-Photoroom.png" alt="Logo">
                    <h3 class="mt-2">Integrated Fitness & Sports Application</h3>
                </div>
                <h4 class="text-center mb-4">Login</h4>
                <form method="post" action="">
                    <div class="mb-3">
                        <label for="email" class="form-label">Email Address</label>
                        <input type="email" name="email" class="form-control" id="email" placeholder="Enter your email" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" id="password" placeholder="Enter your password" required>
                    </div>
                    <button type="submit" name="sub" class="btn btn-primary w-100 mb-3">Continue</button>
                    <p>Don't have an Account? <a href="register.php">Register here</a></p>
                </form>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>