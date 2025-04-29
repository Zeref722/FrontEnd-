<?php
include 'head.php';

// Ensure session is started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Redirect if user is not logged in
if (!isset($_SESSION['user_id']) || !isset($_SESSION['name'])) {
    header('Location: login.php');
    exit();
}

// Database connection check (assuming $con is from head.php)
if (!isset($con) || !$con) {
    die("Error: Database connection failed. Check head.php configuration.");
}

$apiKey = 'AIzaSyCU_qHzAU_xqfFKcc0bY6FFeaoT16-xPcE';
$workoutSchedule = [];
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['selectedOptions'])) {
    $selectedOptions = $_POST['selectedOptions'];
    $user_id = (int)$_SESSION['user_id'];

    // Get the latest membership plan for the user (if any)
    $plan_id = null;
    $plan_query = $con->prepare("SELECT id FROM membership_selection WHERE user_id = ? ORDER BY selected_at DESC LIMIT 1");
    if ($plan_query) {
        $plan_query->bind_param("i", $user_id);
        $plan_query->execute();
        $plan_result = $plan_query->get_result();
        if ($plan_result->num_rows > 0) {
            $plan_row = $plan_result->fetch_assoc();
            $plan_id = (int)$plan_row['id'];
        }
        $plan_query->close();
    } else {
        $error = "Database Error: Failed to prepare plan query - " . $con->error;
    }

    // Save quiz results to the database
    $quizDataJson = json_encode($selectedOptions, JSON_UNESCAPED_SLASHES);
    $stmt = $con->prepare("INSERT INTO quiz_results (user_id, plan_id, quiz_data) VALUES (?, ?, ?)");
    if ($stmt) {
        $stmt->bind_param("iis", $user_id, $plan_id, $quizDataJson);
        if (!$stmt->execute()) {
            $error = "Database Error: Could not save quiz results - " . $stmt->error;
        }
        $stmt->close();
    } else {
        $error = "Database Error: Failed to prepare quiz insert - " . $con->error;
    }

    // Generate workout schedule
    if (!$error) {
        $result = generateWorkoutSchedule($selectedOptions, $apiKey);
        if (is_array($result)) {
            $workoutSchedule = $result;
        } else {
            $error = $result;
            $workoutSchedule = generateFallbackSchedule($selectedOptions);
        }
    } else {
        $workoutSchedule = generateFallbackSchedule($selectedOptions);
    }
} else {
    header('Location: Quiz.html');
    exit();
}

function generateWorkoutSchedule($quizResults, $apiKey) {
    // Note: This endpoint is likely incorrect. Replace with the correct one from Google API docs.
    $url = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key=' . urlencode($apiKey);
    
    $prompt = "Based on the following quiz results, generate a personalized workout schedule:\n";
    $prompt .= json_encode($quizResults, JSON_PRETTY_PRINT);
    $prompt .= "\n\nPlease provide a detailed weekly workout plan in JSON format with the following structure:
    {
        \"Monday\": [
            {\"name\": \"Exercise Name\", \"duration\": \"Duration\", \"sets\": \"Sets (if applicable)\", \"reps\": \"Reps (if applicable)\"},
        ],
        \"Tuesday\": [
            {\"name\": \"Exercise Name\", \"duration\": \"Duration\"}
        ]
    }
    Note: Include sets and reps only for strength training exercises. For cardio or flexibility exercises, omit these fields.";

    $data = [
        'contents' => [
            [
                'parts' => [
                    ['text' => $prompt]
                ]
            ]
        ]
    ];

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json'
    ]);

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    
    if (curl_errno($ch)) {
        $error = "cURL Error: " . curl_error($ch);
        curl_close($ch);
        return $error;
    }
    curl_close($ch);

    if ($httpCode !== 200) {
        return "API Error: Received HTTP code $httpCode - Check endpoint or API key permissions.";
    }

    $responseData = json_decode($response, true);
    
    if (isset($responseData['error'])) {
        return "API Error: " . $responseData['error']['message'];
    }

    if (!isset($responseData['candidates'][0]['content']['parts'][0]['text'])) {
        return "Error: Unexpected API response format - " . json_encode($responseData);
    }

    $scheduleText = $responseData['candidates'][0]['content']['parts'][0]['text'];
    
    preg_match('/{.*}/s', $scheduleText, $matches);
    if (empty($matches)) {
        return "Error: Could not find valid JSON in the response - Raw response: " . $scheduleText;
    }

    $schedule = json_decode($matches[0], true);
    if (json_last_error() !== JSON_ERROR_NONE) {
        return "Error parsing workout schedule: " . json_last_error_msg() . " - Raw JSON: " . $matches[0];
    }

    return $schedule;
}

function generateFallbackSchedule($quizResults) {
    $quizResults = is_array($quizResults) ? $quizResults : [];
    $goal = $quizResults['2'] ?? 'Maintain Fitness';
    $days = $quizResults['5'] ?? '3-4 days';

    $baseSchedule = [
        "Monday" => [["name" => "Warm-up (Jogging)", "duration" => "10 mins"]],
        "Tuesday" => [],
        "Wednesday" => [],
        "Thursday" => [],
        "Friday" => [],
        "Saturday" => [],
        "Sunday" => [],
    ];

    switch ($goal) {
        case "Lose Weight":
            $baseSchedule["Monday"][] = ["name" => "Treadmill Running", "duration" => "30 mins"];
            $baseSchedule["Wednesday"][] = ["name" => "HIIT Workout", "duration" => "20 mins"];
            break;
        case "Build Muscle":
            $baseSchedule["Monday"][] = ["name" => "Bench Press", "duration" => "15 mins", "sets" => "3", "reps" => "10"];
            $baseSchedule["Wednesday"][] = ["name" => "Squats", "duration" => "15 mins", "sets" => "3", "reps" => "12"];
            break;
        case "Improve Flexibility":
            $baseSchedule["Monday"][] = ["name" => "Yoga Stretching", "duration" => "20 mins"];
            break;
        case "Increase Endurance":
            $baseSchedule["Monday"][] = ["name" => "Cycling", "duration" => "25 mins"];
            $baseSchedule["Wednesday"][] = ["name" => "Swimming", "duration" => "30 mins"];
            break;
        default: // Maintain Fitness
            $baseSchedule["Monday"][] = ["name" => "Light Cardio", "duration" => "20 mins"];
    }

    $activeDays = ["Monday", "Wednesday", "Friday"];
    if ($days === "5-6 days") {
        $activeDays = ["Monday", "Tuesday", "Wednesday", "Friday", "Saturday"];
    } elseif ($days === "Daily") {
        $activeDays = array_keys($baseSchedule);
    } elseif ($days === "1-2 days") {
        $activeDays = ["Monday", "Wednesday"];
    }

    foreach ($activeDays as $day) {
        if (empty($baseSchedule[$day])) {
            $baseSchedule[$day] = [["name" => "General Workout", "duration" => "20 mins"]];
        }
    }

    return $baseSchedule;
}

function renderWorkoutSchedule($schedule) {
    $html = '<div class="workout-schedule">';
    foreach ($schedule as $day => $exercises) {
        $html .= "<h2 class='day-header'>$day</h2>";
        $html .= '<table class="table table-striped"><thead><tr><th>#</th><th>Exercise</th><th>Duration</th><th>Sets</th><th>Reps</th></tr></thead><tbody>';
        foreach ($exercises as $index => $exercise) {
            $number = $index + 1;
            $html .= "<tr><td>$number</td><td>" . htmlspecialchars($exercise['name'] ?? 'N/A') . "</td><td>" . htmlspecialchars($exercise['duration'] ?? 'N/A') . "</td><td>" . htmlspecialchars($exercise['sets'] ?? '-') . "</td><td>" . htmlspecialchars($exercise['reps'] ?? '-') . "</td></tr>";
        }
        $html .= '</tbody></table>';
    }
    $html .= '</div>';
    return $html;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Personalized Workout Schedule</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-image: url('https://picsum.photos/1920/1080?blur=10'); background-size: cover; background-position: center; background-attachment: fixed; color: #333; font-family: Arial, sans-serif; }
        .navbar { background-color: rgba(0, 0, 0, 0.83); }
        .navbar-brand, .navbar-text, .btn-login a { color: white !important; }
        .result-container { background-color: rgba(255, 255, 255, 0.9); padding: 2rem; border-radius: 15px; box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1); margin-top: 5rem; margin-bottom: 5rem; max-width: 800px; width: 100%; }
        .workout-schedule table { margin-bottom: 2rem; }
        .day-header { color: #007bff; margin-top: 1.5rem; margin-bottom: 1rem; }
        .table { background-color: white; }
        .error-message { color: red; font-weight: bold; margin-bottom: 1rem; white-space: pre-wrap; }
        .btn-payment { background-color: #ff6600; border-color: #ff6600; color: white; font-weight: bold; }
        .btn-payment:hover { background-color: #e65c00; border-color: #e65c00; }
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
        <div class="result-container">
            <h1 class="text-center mb-4">Your Personalized Workout Schedule</h1>
            <?php if ($error): ?>
                <div class="error-message"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>
            <?php echo renderWorkoutSchedule($workoutSchedule); ?>
            <div class="text-center mt-4">
                <a href="billing.php" class="btn btn-payment">Make Payment</a>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>