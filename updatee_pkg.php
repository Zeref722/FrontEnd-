<?php
session_start();
include 'head.php';

if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: admin_login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pkg_id = mysqli_real_escape_string($con, $_POST['pkg_id']);
    $new_name = !empty($_POST['new_name']) ? mysqli_real_escape_string($con, $_POST['new_name']) : $pkg_id;
    $new_price = !empty($_POST['new_price']) ? floatval($_POST['new_price']) : null;
    $new_add_ons = !empty($_POST['new_add_ons']) ? mysqli_real_escape_string($con, $_POST['new_add_ons']) : null;

    $updates = [];
    if ($new_name !== $pkg_id) $updates[] = "package_name = '$new_name'";
    if ($new_price !== null) $updates[] = "package_price = $new_price";
    if ($new_add_ons !== null) $updates[] = "add_ons = '$new_add_ons'";

    if (!empty($updates)) {
        $update_query = "UPDATE membership_selection SET " . implode(', ', $updates) . " WHERE package_name = '$pkg_id'";
        if ($con->query($update_query)) {
            echo "<script>alert('Package updated successfully'); window.location.href = 'admin_panel.php';</script>";
        } else {
            echo "<script>alert('Error updating package: " . $con->error . "'); window.location.href = 'admin_panel.php';</script>";
        }
    } else {
        echo "<script>alert('No changes provided'); window.location.href = 'admin_panel.php';</script>";
    }
}
?>