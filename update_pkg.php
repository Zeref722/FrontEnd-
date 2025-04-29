<?php
session_start();
include 'head.php'; // Assuming this file contains your database connection ($con)

if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: admin_login.php');
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $pkg_id = mysqli_real_escape_string($con, $_POST['pkg_id']); // Original package name
    $new_name = mysqli_real_escape_string($con, $_POST['new_name']);
    $new_price = floatval($_POST['new_price']);
    $new_add_ons = mysqli_real_escape_string($con, $_POST['new_add_ons']);

    // Prepare the update query
    $update_query = "UPDATE membership_selection SET ";
    $updates = [];
    $params = [];
    $types = "";

    if (!empty($new_name)) {
        $updates[] = "package_name = ?";
        $params[] = $new_name;
        $types .= "s";
    }
    if (!empty($new_price)) {
        $updates[] = "package_price = ?";
        $params[] = $new_price;
        $types .= "d";
    }
    if (!empty($new_add_ons)) {
        $updates[] = "add_ons = ?";
        $params[] = $new_add_ons;
        $types .= "s";
    }

    if (empty($updates)) {
        $_SESSION['message'] = "No changes provided to update.";
        header('Location: admin_panel.php');
        exit();
    }

    $update_query .= implode(", ", $updates) . " WHERE package_name = ?";
    $params[] = $pkg_id;
    $types .= "s";

    // Prepare and execute the statement
    $stmt = $con->prepare($update_query);
    $stmt->bind_param($types, ...$params);

    if ($stmt->execute()) {
        $_SESSION['message'] = "Package updated successfully!";
    } else {
        $_SESSION['message'] = "Error updating package: " . $stmt->error;
    }

    $stmt->close();
} else {
    $_SESSION['message'] = "Invalid request.";
}

header('Location: admin_panel.php');
exit();
?>