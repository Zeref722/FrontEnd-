<?php
include 'head.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $birthdate = $_POST['birthdate'];
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $password = mysqli_real_escape_string($con, $_POST['password']);
    $phone = mysqli_real_escape_string($con, $_POST['phone']);
    $gym_experience = $_POST['gym_experience'];
    $blood_group = $_POST['blood_group'];
    $allergies = mysqli_real_escape_string($con, $_POST['allergies']);
    $past_surgeries = mysqli_real_escape_string($con, $_POST['past_surgeries']);
    $health_issues = mysqli_real_escape_string($con, $_POST['health_issues']);
    $emergency_contact = mysqli_real_escape_string($con, $_POST['emergency_contact']);
    $emergency_phone = mysqli_real_escape_string($con, $_POST['emergency_phone']);

    $check = $con->query("SELECT id FROM gym_membership WHERE email = '$email'");
    if ($check->num_rows > 0) {
        echo "<script>alert('Email already registered!');</script>";
    } else {
        $stmt = $con->prepare("INSERT INTO gym_membership (name, birthdate, email, password, phone, gym_experience, blood_group, allergies, past_surgeries, health_issues, emergency_contact, emergency_phone) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssssssssss", $name, $birthdate, $email, $password, $phone, $gym_experience, $blood_group, $allergies, $past_surgeries, $health_issues, $emergency_contact, $emergency_phone);
        
        if ($stmt->execute()) {
            $_SESSION['user_id'] = $con->insert_id;
            $_SESSION['name'] = $name;
            echo "<script>alert('Registration Successful'); window.location.href = 'PKG.php';</script>";
        } else {
            echo "<script>alert('Error: " . $stmt->error . "');</script>";
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gym Membership Form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { margin: 0; padding: 0; background: #000; color: #fff; font-family: Arial, sans-serif; overflow-x: hidden; }
        .signup-container { display: flex; min-height: 100vh; }
        .image-section { flex: 1; background: url('css/jm.jpg') no-repeat center center/cover; }
        .form-section { flex: 1; display: flex; justify-content: center; align-items: center; background: rgba(0, 0, 0, 0.8); padding: 20px; }
        .signup-form { width: 100%; max-width: 400px; }
        .signup-logo { text-align: center; margin-bottom: 15px; }
        .signup-logo img { width: 80px; }
        .btn-primary { background-color: #ff6600; border-color: #ff6600; }
        .btn-primary:hover { background-color: #e65c00; border-color: #e65c00; }
        form .mb-3 { margin-bottom: 10px; }
        h3, h4 { font-size: 1rem; }
    </style>
</head>
<body>
    <div class="signup-container">
        <div class="image-section"></div>
        <div class="form-section">
            <div class="signup-form">
                <div class="signup-logo">
                    <img src="css/PRO-Photoroom.png" alt="Logo">
                    <h3 class="mt-2">Integrated Fitness & Sports Application</h3>
                </div>
                <h4 class="text-center mb-3">Gym Membership Form</h4>
                <form id="membershipForm" method="post" action="">
                    <div class="mb-3"><label for="name" class="form-label">Full Name</label><input type="text" class="form-control" id="name" name="name" required></div>
                    <div class="mb-3"><label for="birthdate" class="form-label">Date of Birth</label><input type="date" class="form-control" id="birthdate" name="birthdate" required></div>
                    <div class="mb-3"><label for="email" class="form-label">Email Address</label><input type="email" class="form-control" id="email" name="email" required></div>
                    <div class="mb-3"><label for="password" class="form-label">Password</label><input type="password" class="form-control" id="password" name="password" required></div>
                    <div class="mb-3"><label for="phone" class="form-label">Phone Number</label><input type="tel" class="form-control" id="phone" name="phone" required></div>
                    <div class="mb-3"><label for="gym-experience" class="form-label">Have you ever done gym before?</label><select class="form-select" id="gym-experience" name="gym_experience" required><option value="">Select an option</option><option value="yes">Yes</option><option value="no">No</option></select></div>
                    <div class="mb-3"><label for="blood-group" class="form-label">Blood Group</label><select class="form-select" id="blood-group" name="blood_group" required><option value="">Select blood group</option><option value="A+">A+</option><option value="A-">A-</option><option value="B+">B+</option><option value="B-">B-</option><option value="AB+">AB+</option><option value="AB-">AB-</option><option value="O+">O+</option><option value="O-">O-</option></select></div>
                    <div class="mb-3"><label for="allergies" class="form-label">Allergies (if any)</label><textarea class="form-control" id="allergies" name="allergies" rows="2"></textarea></div>
                    <div class="mb-3"><label for="past-surgeries" class="form-label">Past Surgeries (if any)</label><textarea class="form-control" id="past-surgeries" name="past_surgeries" rows="2"></textarea></div>
                    <div class="mb-3"><label for="health-issues" class="form-label">Any Health Issues</label><textarea class="form-control" id="health-issues" name="health_issues" rows="2"></textarea></div>
                    <div class="mb-3"><label for="emergency-contact" class="form-label">Emergency Contact Name</label><input type="text" class="form-control" id="emergency_contact" name="emergency_contact" required></div>
                    <div class="mb-3"><label for="emergency-phone" class="form-label">Emergency Contact Phone</label><input type="tel" class="form-control" id="emergency_phone" name="emergency_phone" required></div>
                    <button type="submit" class="btn btn-primary w-100 mb-2" name="submit">Submit Membership Form</button>
                </form>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>