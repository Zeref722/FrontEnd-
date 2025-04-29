<?php

include 'head.php';

if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: admin_login.php');
    exit();
}

$new_members_query = $con->query("SELECT * FROM gym_membership WHERE created_at >= DATE_SUB(NOW(), INTERVAL 7 DAY) ORDER BY created_at DESC");
$all_members_query = $con->query("SELECT * FROM gym_membership ORDER BY created_at DESC");
$plans_query = $con->query("SELECT ms.*, gm.name, gm.email FROM membership_selection ms JOIN gym_membership gm ON ms.user_id = gm.id ORDER BY ms.selected_at DESC");

$sales_day = $con->query("SELECT SUM(package_price) as total FROM membership_selection WHERE DATE(selected_at) = CURDATE()")->fetch_assoc()['total'] ?? 0;
$sales_month = $con->query("SELECT SUM(package_price) as total FROM membership_selection WHERE MONTH(selected_at) = MONTH(CURDATE()) AND YEAR(selected_at) = YEAR(CURDATE())")->fetch_assoc()['total'] ?? 0;
$sales_3months = $con->query("SELECT SUM(package_price) as total FROM membership_selection WHERE selected_at >= DATE_SUB(CURDATE(), INTERVAL 3 MONTH)")->fetch_assoc()['total'] ?? 0;
$sales_6months = $con->query("SELECT SUM(package_price) as total FROM membership_selection WHERE selected_at >= DATE_SUB(CURDATE(), INTERVAL 6 MONTH)")->fetch_assoc()['total'] ?? 0;

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Panel - PRO-FITT</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #000; color: #fff; font-family: Arial, sans-serif; }
        .navbar { background-color: rgba(0, 0, 0, 0.83); }
        .navbar-brand, .nav-link { color: white !important; }
        .container { margin-top: 2rem; }
        .tab-content { background: rgba(255, 255, 255, 0.9); color: #333; padding: 20px; border-radius: 10px; }
        .btn-primary { background-color: #ff6600; border-color: #ff6600; }
        .btn-primary:hover { background-color: #e65c00; border-color: #e65c00; }
        table { background: white; }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">PRO-FITT Admin</a>
            <div class="d-flex">
                <a href="admin_logout.php" class="btn btn-primary">Logout</a>
            </div>
        </div>
    </nav>

    <div class="container">
        <?php
        if (isset($_SESSION['message'])) {
            echo '<div class="alert alert-info">' . htmlspecialchars($_SESSION['message']) . '</div>';
            unset($_SESSION['message']);
        }
        ?>
        <ul class="nav nav-tabs" id="adminTabs" role="tablist">
            <li class="nav-item"><a class="nav-link active" id="new-members-tab" data-bs-toggle="tab" href="#new-members" role="tab">New Members</a></li>
            <li class="nav-item"><a class="nav-link" id="all-members-tab" data-bs-toggle="tab" href="#all-members" role="tab">All Members</a></li>
            <li class="nav-item"><a class="nav-link" id="plans-tab" data-bs-toggle="tab" href="#plans" role="tab">Plans Chosen</a></li>
            <li class="nav-item"><a class="nav-link" id="modify-pkg-tab" data-bs-toggle="tab" href="#modify-pkg" role="tab">Modify PKG</a></li>
            <li class="nav-item"><a class="nav-link" id="sales-tab" data-bs-toggle="tab" href="#sales" role="tab">Sales</a></li>
        </ul>

        <div class="tab-content" id="adminTabContent">
            <!-- New Members -->
            <div class="tab-pane fade show active" id="new-members" role="tabpanel">
                <h3>New Members (Last 7 Days)</h3>
                <table class="table table-striped">
                    <thead><tr><th>ID</th><th>Name</th><th>Email</th><th>Phone</th><th>Registered At</th></tr></thead>
                    <tbody>
                        <?php while ($row = $new_members_query->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo $row['id']; ?></td>
                                <td><?php echo htmlspecialchars($row['name']); ?></td>
                                <td><?php echo htmlspecialchars($row['email']); ?></td>
                                <td><?php echo htmlspecialchars($row['phone']); ?></td>
                                <td><?php echo $row['created_at']; ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>

            <!-- All Members -->
            <div class="tab-pane fade" id="all-members" role="tabpanel">
                <h3>All Members</h3>
                <table class="table table-striped">
                    <thead><tr><th>ID</th><th>Name</th><th>Email</th><th>Phone</th><th>Registered At</th></tr></thead>
                    <tbody>
                        <?php while ($row = $all_members_query->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo $row['id']; ?></td>
                                <td><?php echo htmlspecialchars($row['name']); ?></td>
                                <td><?php echo htmlspecialchars($row['email']); ?></td>
                                <td><?php echo htmlspecialchars($row['phone']); ?></td>
                                <td><?php echo $row['created_at']; ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>

            <!-- Plans Chosen -->
            <div class="tab-pane fade" id="plans" role="tabpanel">
                <h3>Plans Chosen by Users</h3>
                <table class="table table-striped">
                    <thead><tr><th>User ID</th><th>Name</th><th>Email</th><th>Package</th><th>Price (₹)</th><th>Add-ons</th><th>Selected At</th></tr></thead>
                    <tbody>
                        <?php while ($row = $plans_query->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo $row['user_id']; ?></td>
                                <td><?php echo htmlspecialchars($row['name']); ?></td>
                                <td><?php echo htmlspecialchars($row['email']); ?></td>
                                <td><?php echo htmlspecialchars($row['package_name']); ?></td>
                                <td><?php echo number_format($row['package_price'], 2); ?></td>
                                <td><?php echo htmlspecialchars($row['add_ons']); ?></td>
                                <td><?php echo $row['selected_at']; ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>

            <!-- Modify Packages -->
            <div class="tab-pane fade" id="modify-pkg" role="tabpanel">
                <h3>Modify Packages</h3>
                <form method="POST" action="update_pkg.php">
                    <div class="mb-3">
                        <label for="pkg_id" class="form-label">Select Package to Modify</label>
                        <select name="pkg_id" id="pkg_id" class="form-select" required>
                            <option value="">Select Package</option>
                            <option value="1 Month Plan">1 Month Plan</option>
                            <option value="3 Months Plan">3 Months Plan</option>
                            <option value="6 Months Plan">6 Months Plan</option>
                            <option value="1 Year Plan">1 Year Plan</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="new_name" class="form-label">New Package Name</label>
                        <input type="text" name="new_name" id="new_name" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="new_price" class="form-label">New Price (₹)</label>
                        <input type="number" name="new_price" id="new_price" class="form-control" step="0.01">
                    </div>
                    <div class="mb-3">
                        <label for="new_add_ons" class="form-label">New Add-ons (comma-separated)</label>
                        <input type="text" name="new_add_ons" id="new_add_ons" class="form-control">
                    </div>
                    <button type="submit" class="btn btn-primary">Update Package</button>
                </form>
            </div>

            <!-- Sales -->
            <div class="tab-pane fade" id="sales" role="tabpanel">
                <h3>Total Sales</h3>
                <table class="table table-striped">
                    <thead><tr><th>Period</th><th>Total Sales (₹)</th></tr></thead>
                    <tbody>
                        <tr><td>Today</td><td><?php echo number_format($sales_day, 2); ?></td></tr>
                        <tr><td>This Month</td><td><?php echo number_format($sales_month, 2); ?></td></tr>
                        <tr><td>Last 3 Months</td><td><?php echo number_format($sales_3months, 2); ?></td></tr>
                        <tr><td>Last 6 Months</td><td><?php echo number_format($sales_6months, 2); ?></td></tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>