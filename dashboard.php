<?php
include 'head.php';

if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('Please log in first!'); window.location.href = 'login.php';</script>";
    exit;
}

$user_id = $_SESSION['user_id'];
$result = $con->query("SELECT * FROM membership_selection WHERE user_id = $user_id");
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #000; color: #fff; font-family: Arial, sans-serif; }
        .navbar { background-color: rgba(0, 0, 0, 0.83); }
        .navbar-brand, .navbar-text, .btn-login a { color: white !important; }
        .container { margin-top: 5rem; }
        .btn-primary { background-color: #ff6600; border-color: #ff6600; }
        .btn-primary:hover { background-color: #e65c00; border-color: #e65c00; }
        a { color: #ff6600; }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <a class="navbar-brand" href="temp.php">PRO-FITT</a>
            <div class="d-flex">
                <span class="navbar-text me-2">Welcome, <?php echo htmlspecialchars($_SESSION['name']); ?>!</span>
                <button class="btn btn-login"><a href="logout.php">LOGOUT</a></button>
            </div>
        </div>
    </nav>

    <div class="container">
        <h1>Hello <?php echo htmlspecialchars($_SESSION['name']); ?></h1>
        <h2>Your Membership</h2>
        <?php if ($result->num_rows > 0): ?>
            <table class="table table-striped text-white">
                <thead><tr><th>Package</th><th>Price</th><th>Add-ons</th><th>Selected At</th></tr></thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['package_name']); ?></td>
                            <td>₹<?php echo number_format($row['package_price'], 2); ?></td>
                            <td><?php echo htmlspecialchars($row['add_ons']); ?></td>
                            <td><?php echo $row['selected_at']; ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No membership selected yet. <a href="PKG.php">Choose a plan</a></p>
        <?php endif; ?>
        <a href="Quiz.html" class="btn btn-primary">Take Fitness Quiz</a>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>