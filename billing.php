<?php

include 'head.php';

if (!isset($_SESSION['user_id']) || !isset($_SESSION['name'])) {
    header('Location: login.php');
    exit();
}

if (!$con) {
    die("Database connection failed: " . mysqli_connect_error());
}

$user_id = (int)$_SESSION['user_id'];
$error = '';

// Fetch user details
$user_query = $con->prepare("SELECT name, phone FROM gym_membership WHERE id = ?");
$user_query->bind_param("i", $user_id);
$user_query->execute();
$user_result = $user_query->get_result();
$user = $user_result->fetch_assoc();
$user_query->close();

// Fetch latest membership selection
$selection_query = $con->prepare("SELECT id, package_name, package_price, add_ons FROM membership_selection WHERE user_id = ? ORDER BY selected_at DESC LIMIT 1");
$selection_query->bind_param("i", $user_id);
$selection_query->execute();
$selection_result = $selection_query->get_result();
$selection = $selection_result->num_rows > 0 ? $selection_result->fetch_assoc() : null;
$selection_query->close();

// Determine package duration based on package name
function getPackageDuration($package_name) {
    switch ($package_name) {
        case '1 Month Plan': return '1 Month';
        case '3 Months Plan': return '3 Months';
        case '6 Months Plan': return '6 Months';
        case '1 Year Plan': return '1 Year';
        default: return 'Unknown';
    }
}


if ($selection) {
    $plan_id = (int)$selection['id'];
    $bill_query = $con->prepare("SELECT * FROM membership_bills WHERE plan_id = ?");
    $bill_query->bind_param("i", $plan_id);
    $bill_query->execute();
    $bill_result = $bill_query->get_result();
    
    if ($bill_result->num_rows == 0) {
        $package_name = $selection['package_name'];
        $package_duration = getPackageDuration($package_name);
        $phone = $user['phone'];
        $add_ons = $selection['add_ons'];
        $amount = $selection['package_price'];
        
        $insert_bill = $con->prepare("INSERT INTO membership_bills (user_id, plan_id, package_name, package_duration, phone, add_ons, amount) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $insert_bill->bind_param("iissssd", $user_id, $plan_id, $package_name, $package_duration, $phone, $add_ons, $amount);
        if (!$insert_bill->execute()) {
            $error = "Error creating bill: " . $insert_bill->error;
        }
        $insert_bill->close();
    }
    $bill_query->close();
}


$bills_query = $con->prepare("SELECT mb.*, ms.package_name, ms.package_price, ms.add_ons FROM membership_bills mb JOIN membership_selection ms ON mb.plan_id = ms.id WHERE mb.user_id = ? ORDER BY mb.created_at DESC");
$bills_query->bind_param("i", $user_id);
$bills_query->execute();
$bills_result = $bills_query->get_result();
$bills = [];
while ($row = $bills_result->fetch_assoc()) {
    $bills[] = $row;
}
$bills_query->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Billing - PRO-FITT</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #000; color: #fff; font-family: Arial, sans-serif; }
        .navbar { background-color: rgba(0, 0, 0, 0.83); }
        .navbar-brand, .navbar-text, .btn-login a { color: white !important; }
        .container { margin-top: 5rem; margin-bottom: 5rem; }
        .billing-container { background: rgba(255, 255, 255, 0.9); padding: 2rem; border-radius: 10px; color: #333; }
        .btn-primary { background-color: #ff6600; border-color: #ff6600; }
        .btn-primary:hover { background-color: #e65c00; border-color: #e65c00; }
        .table { background: white; }
        .error { color: red; font-weight: bold; }
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
        <div class="billing-container">
            <h1 class="text-center mb-4">Your Billing Details</h1>
            <?php if ($error): ?>
                <p class="error text-center"><?php echo htmlspecialchars($error); ?></p>
            <?php endif; ?>
            <?php if (empty($bills)): ?>
                <p class="text-center">No billing records found. Please select a membership plan first.</p>
                <div class="text-center">
                    <a href="PKG.php" class="btn btn-primary">Choose a Plan</a>
                </div>
            <?php else: ?>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Bill ID</th>
                            <th>User Name</th>
                            <th>Package</th>
                            <th>Duration</th>
                            <th>Phone</th>
                            <th>Add-ons</th>
                            <th>Total Bill (₹)</th>
                            <th>Status</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($bills as $bill): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($bill['bill_id']); ?></td>
                                <td><?php echo htmlspecialchars($user['name']); ?></td>
                                <td><?php echo htmlspecialchars($bill['package_name']); ?></td>
                                <td><?php echo htmlspecialchars($bill['package_duration']); ?></td>
                                <td><?php echo htmlspecialchars($bill['phone']); ?></td>
                                <td><?php echo htmlspecialchars($bill['add_ons'] ?? 'None'); ?></td>
                                <td><?php echo number_format($bill['amount'], 2); ?></td>
                                <td><?php echo htmlspecialchars($bill['payment_status']); ?></td>
                                <td><?php echo htmlspecialchars($bill['created_at']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>